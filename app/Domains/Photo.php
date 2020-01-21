<?php

namespace App\Domains;

use Illuminate\Http\UploadedFile;

class Photo
{
    const PHOTO = 1;
    const THUMB = 2;

    private $file;

    private $name;
    private $folder;
    private $path;
    private $ext;

    private $mime;
    private $size;

    private $saveFileName;

    private $thumbFileName;
    private $thumbSuffix;
    private $thumbWidth;

    private $S3;

    function __construct(UploadedFile $file, $folder)
    {
        $this->file = $file;

        $this->name = msDate();
        $this->folder = $folder;
        $this->path = config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . $this->folder;
        $this->ext  = $this->file->getClientOriginalExtension();
        $this->mime = $this->file->getMimeType();
        $this->size = $this->file->getClientSize();

        $this->saveFileName = $this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext;

        $this->thumbWidth = config('photo.thumbnail.width');
        $this->thumbSuffix = config('photo.thumbnail.suffix');
        $this->thumbFileName = $this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->thumbSuffix . '.' . $this->ext;

        $this->S3 = [
            'url'    => config('filesystems.disks.s3.url'),
            'bucket' => config('filesystems.disks.s3.bucket'),
            'folder' => config('filesystems.disks.s3.folder.image')
        ];
    }

    public function save()
    {
        $fileName = $this->folder . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext;
        \Storage::disk('local')->put($fileName, \File::get($this->file));

        return $this;
    }

    public function uploadS3($type = null)
    {
        $filename = $this->name . '.' . $this->ext;
        $saveFile = $this->saveFileName;

        if ($type == self::THUMB) {
            $filename = $this->name . '.' . $this->thumbSuffix . '.' . $this->ext;
            $saveFile = $this->thumbFileName;
        }

        $file = $this->S3['folder'] . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $filename;

        if (env('S3_ENABLE', false)) {
            \Storage::disk('s3')->put($file, \File::get($saveFile), 'public');
        }

        return $this;
    }

    public function thumbnail()
    {
        $img = \Image::make($this->saveFileName);
        $img->resize($this->thumbWidth, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save($this->thumbFileName);

        return $this;
    }

    public function clear()
    {
        \File::delete([
            $this->saveFileName,
            $this->thumbFileName
        ]);

        return $this;
    }

    public function getParams($request = [])
    {
        return [
            'mime' => $this->mime,
            'path' => implode("", $this->S3) . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR,
            'name' => $this->name,
            'size' => $this->size,
            'ext'  => $this->ext,
            'description' => isset($request['description']) ? $request['description'] : null,
            'location'    => isset($request['location']) ? $request['location'] : null,
        ];
    }

    public static function make($file, $folder = 'photo')
    {
        return new Photo($file, $folder);
    }
}