<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Photo;
use App\Traits\Find;
use App\Traits\Resource;

class PhotoRepository
{
    use Find, Resource;

    public $model;
    public $file;
    public $baseRelation;

    public function __construct(Photo $model, File $file)
    {
        $this->model = $model;
        $this->file = $file;
    }



    public function create($request, $file)
    {
        $photo = new $this->model;

        $photo->setAttribute('imageable_type', $this->getClassModel($request->model));
        $photo->setAttribute('imageable_id', $request->id);
        $photo->setAttribute('user_id', $request->user_id);
        $photo->setAttribute('file_id', $file->id);

        $photo->save();

        return $photo;
    }

    public function assignThumbnail(Photo $photo)
    {
        $model = $this->model;
        $model::where('imageable_id', $photo->imageable_id)->where('imageable_type', $photo->imageable_type)
            ->update(['thumbnail' => false]);

        $photo->setAttribute('thumbnail', true);
        return $photo->save();
    }

    public function clearThumbnail(Photo $photo)
    {
        if ($photo->thumbnail == false)
            return false;

        $photo->setAttribute('thumbnail', false);
        $photo->save();
        $imageable = $photo->imageable;
        $imageable->setAttribute('thumbnail', '');
        $imageable->save();

        return true;
    }

    // public function getByRelation($relation, $id = null)
    // {
    //     $model = $this->model;
    //     $model = $model::with([$relation, $this->baseRelation])->has($relation)->has($this->baseRelation);

    //     if ($id) {
    //         $model->whereHas($relation, function ($query) use ($relation, $id) {
    //             $query->where($relation.'.id', $id);
    //         });
    //     }

    //     return $model->orderBy($this->sorting_column, $this->sorting_direction)->paginate($this->perPage);
    // }
}
