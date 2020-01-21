<?php

namespace App\Domains;

use Illuminate\Http\UploadedFile;

class File
{
    private $file;

    private $name;
    private $folder;
    private $path;
    private $ext;

    private $mime;
    private $size;

    private $saveFileName;

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

        $file = $this->S3['folder'] . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $filename;

        if (env('S3_ENABLE', false)) {
            \Storage::disk('s3')->put($file, \File::get($saveFile), 'public');
        }

        return $this;
    }

    public function clear()
    {
        \File::delete([
            $this->saveFileName
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
        ];
    }

    public static function make($file, $folder = 'photo')
    {
        return new File($file, $folder);
    }
}