<?php

namespace App\Domains;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\Jobs\UploadVideo;
use Symfony\Component\HttpFoundation\File\File;

class Video
{
    const VIDEO = 1;
    const THUMB = 2;

    const LOG_FILE = 'upload-video.log';

    public static $load = true;

    public $exception = null;

    private $file;
    private $request;
    private $basePath;

    private $name;
    private $folder;
    private $path;
    private $ext;

    private $loadUrl = 'api/video/queue-download';
    private $deleteUrl = 'api/video/queue-delete';

    private $queueFolder;
    private $queuePath;
    private $queueFileName;

    private $mime;
    private $size;

    private $loadFileName;
    private $saveFileName;

    private $thumbFrame;
    private $thumbFileName;
    private $thumbSuffix;

    private $start;
    private $duration;
    private $format;

    private $S3;

    function __construct($file, $request, $folder)
    {
        $this->name = msDate();
        $this->folder = $folder;
        $this->request = $request;

        $this->basePath = config('filesystems.disks.local.root');

        $this->queueFolder = config('video.queue.folder');
        $this->queuePath = $this->basePath . DIRECTORY_SEPARATOR . $this->queueFolder;
        $this->queueFileName = is_string($file) ? $file : null;

        $this->path = $this->basePath . DIRECTORY_SEPARATOR . $this->folder;
        $this->ext  = config('video.x264.extension');

        $this->file = is_string($file) ? $this->load($file) : $file;

        $this->loadFileName = is_string($file) ? $this->path . DIRECTORY_SEPARATOR . $file : null;
        $this->saveFileName = $this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext;

        $this->thumbSuffix = config('video.thumbnail.suffix');
        $this->thumbFileName = $this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->thumbSuffix;
        $this->thumbFrame = TimeCode::fromSeconds(config('video.thumbnail.frame'));

        $this->start = TimeCode::fromSeconds(0);
        $this->duration = TimeCode::fromSeconds(config('video.duration'));
        $this->format = new X264(config('video.x264.audio'), config('video.x264.video'));
        $this->S3 = [
            'url'    => config('filesystems.disks.s3.url'),
            'bucket' => config('filesystems.disks.s3.bucket'),
            'folder' => config('filesystems.disks.s3.folder.movie')
        ];
    }

    public function save()
    {
        $fileName = $this->name . '.' . $this->file->getClientOriginalExtension();
        $saveFileName = $this->queuePath . DIRECTORY_SEPARATOR . $fileName;
        $fileName = $this->queueFolder . DIRECTORY_SEPARATOR . $fileName;

        error_log(print_r("Video/save : " . $saveFileName, TRUE));

        \Storage::disk('local')->put($fileName, \File::get($this->file));

        $FF = FFProbe::create();
        $probe = $FF->format($saveFileName);
        $this->size = $probe->get('size');
        $this->mime = mime_content_type($saveFileName);
        error_log("Video/save : mimeType:" . $this->mime . " Size:" . $this->size);

        return $this;
    }

    public function load($file)
    {
        if (self::$load !== true)
            return $file;

        try {
            // Do not forget, the correct operation of the script depends on env('APP_URL')
            $url = url($this->loadUrl, ['file' => $file]);
            $contents = file_get_contents($url, 'r');
            $fileName = $this->folder . DIRECTORY_SEPARATOR . $file;
            \Storage::disk('local')->put($fileName, $contents);
            error_log(print_r("Video/load : " . $this->path . DIRECTORY_SEPARATOR . $file, TRUE));

            return new File($this->path . DIRECTORY_SEPARATOR . $file);
        } catch (\ErrorException $e) {
            $this->exception = $this->saveLog($e);
        }
    }

    public function cut()
    {
        error_log("CUT---");
        $FF = FFMpeg::create();
        error_log("Start Cutting");

        $video = $FF->open($this->file->getRealPath());
        error_log("Start Cutting : " . $this->file->getRealPath());
        error_log("saveFileName : " . $this->saveFileName);
        error_log("video duration : " . print_r($video->getStreams()->videos()->first()->get('duration'), TRUE));

        if ($video->getStreams()->videos()->first()->get('duration') > config('video.duration')) {
            try {
                $video->filters()->clip($this->start, $this->duration);
            } catch (Exception $e) {
                error_log("Video cliping is failed....");
                error_log(print_r($e, TRUE));
            }
            error_log("Start Cutting - 1");
        }

        // try {
        //     $video->save($this->format, $this->saveFileName);
        // } catch (Exception $e) {
        //     error_log("Video saving is failed....");
        //     error_log(print_r($e, TRUE));
        // }
        $this->saveFileName = $this->file->getRealPath();

        error_log("Video saving is successed....");
        error_log(print_r("Video/cut : " . $this->file->getRealPath(), TRUE));
        error_log(print_r("Video/cut : " . $this->saveFileName, TRUE));

        $probe = $FF->getFFProbe()->format($this->saveFileName);
        $this->size = $probe->get('size');
        $this->mime = mime_content_type($this->saveFileName);
        $this->duration = $probe->get('duration');

        return $this;
    }

    public function uploadS3($type = null)
    {
        $filename = $this->name . '.' . $this->ext;
        $saveFile = $this->saveFileName;

        error_log(print_r("Video/uploadS3 : " . $filename, TRUE));

        if ($type == self::THUMB) {
            $filename = $this->name . '.' . $this->thumbSuffix;
            $saveFile = $this->thumbFileName;
        }

        $file = $this->S3['folder'] . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $filename;
        error_log("s3 file path : " . $file);
        error_log("s3 file local path : " . $saveFile);
        if (env('S3_ENABLE', false)) {
            \Storage::disk('s3')->put($file, \File::get($saveFile), 'public');
        }

        return $this;
    }

    public function thumbnail()
    {
        $frame = config('video.thumbnail.frame');
        if ($this->duration <= $frame) {
            $duration = (float)($this->duration - ($this->duration / $frame));
            $this->thumbFrame = TimeCode::fromSeconds($duration);
        }

        $FF = FFMpeg::create();
        $frame = $FF->open($this->saveFileName)->frame($this->thumbFrame);
        $frame->save($this->thumbFileName);
        error_log(print_r("Video/thumbnail : " . $this->thumbFileName, TRUE));

        return $this;
    }

    public function clear()
    {
        \File::delete([
            $this->path . DIRECTORY_SEPARATOR . $this->queueFileName,
            $this->loadFileName,
            $this->saveFileName,
            $this->thumbFileName
        ]);

        try {
            $client = new \GuzzleHttp\Client(['http_errors' => false]);
            $client->request('GET', url($this->deleteUrl, ['file' => $this->queueFileName]));
        } catch (\ErrorException $e) {
            $this->exception = $e;
        }

        return $this;
    }

    public function getParams()
    {
        return [
            'mime' => $this->mime,
            'path' => implode("", $this->S3) . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR,
            'name' => $this->name,
            'size' => $this->size,
            'ext'  => $this->ext,
            'description' => isset($this->request['description']) ? $this->request['description'] : null,
            'location'    => isset($this->request['location']) ? $this->request['location'] : null,
            'request'     => $this->request
        ];
    }

    public function publishToQueue()
    {
        \Queue::pushOn('upload-video', new UploadVideo($this->getParams()));

        return $this;
    }

    public static function make($file, $request, $folder = 'video')
    {
        return new Video($file, $request, $folder);
    }

    public function download()
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $this->file;
        if (\File::exists($file)) {
            return response()->download($file);
        }
    }

    public function delete()
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $this->file;
        if (\File::exists($file)) {
            \File::delete($this->path . DIRECTORY_SEPARATOR . $this->file);
            return statusTrue(['message' => 'File has been deleted']);
        }
    }

    private function saveLog($exception)
    {
        \Log::useFiles(storage_path('logs') . DIRECTORY_SEPARATOR . self::LOG_FILE);
        \Log::alert(is_string($exception) ? $exception : $exception->getMessage());

        return $exception;
    }
}
