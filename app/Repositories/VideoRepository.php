<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Video;
use App\Traits\Find;
use App\Traits\Resource;

class VideoRepository
{
    use Find, Resource;

    public $model;
    public $file;

    public function __construct(Video $model, File $file)
    {
        $this->model = $model;
        $this->file = $file;
    }

    public function create($request, $file)
    {
        $video = new $this->model;

        $video->setAttribute('movieable_type', $this->getClassModel($request->model));
        $video->setAttribute('movieable_id', $request->id);
        $photo->setAttribute('user_id', $request->user_id);
        $video->setAttribute('file_id', $file->id);

        $video->save();

        return $video;
    }

    public function assignThumbnail(Video $video)
    {
        $model = $this->model;
        $model::where('movieable_id', $video->movieable_id)->where('movieable_type', $video->movieable_type)
            ->update(['thumbnail' => false]);

        $video->setAttribute('thumbnail', true);
        return $video->save();
    }

    public function clearThumbnail(Video $video)
    {
        if ($video->thumbnail == false)
            return false;

        $video->setAttribute('thumbnail', false);
        $video->save();
        $movieable = $video->movieable();
        $movieable->setAttribute('thumbnail', '');
        $movieable->save();

        return true;
    }
}
