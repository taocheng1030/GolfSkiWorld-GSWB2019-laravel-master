<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository
{
    public $model;
    public $request;
    public $baseRelation;

    public $allRelations = [
        \App\User::class => 'users',
        \App\Models\Deal::class => 'deals',
        \App\Models\Lastminute::class => 'lastminutes',
        \App\Models\Resort::class => 'resorts',
        \App\Models\Restaurant::class => 'restaurants',
        \App\Models\Accommodation::class => 'accommodations',
        \App\Models\Awardinfo::class => 'awardinfos',
        \App\Models\About::class => 'abouts',
        \App\Models\Destinfo::class => 'destinfos',
        \App\Models\Article::class => 'articles',
        \App\Models\Photo::class => 'photos',
        \App\Models\Video::class => 'videos',
        \App\Models\Site::class => 'sites'
    ];

    public $excludedCategory = ['users'];
    public $excludedDestination = ['deals', 'lastminutes', 'users'];

    public $perPage;

    public $sorting_column = 'created_at';
    public $sorting_direction = SORT_DESC;

    public $S3;

    public function __construct(File $model)
    {
        $this->model = $model;
        $this->S3 = [
            'photos' => config('filesystems.disks.s3.folder.image') . DIRECTORY_SEPARATOR . 'photo',
            'videos' => config('filesystems.disks.s3.folder.movie') . DIRECTORY_SEPARATOR . 'video',
        ];
    }

    public function setRelation($name)
    {
        $this->baseRelation = $name;
        $this->model->setFileRelation($name);
    }

    public function getAll()
    {
        $model = $this->model;
        $model = $model::with($this->localizeRelations())->has($this->baseRelation);

        return $model->orderBy($this->sorting_column, $this->sorting_direction)->paginate($this->perPage);
    }

    public function getTrash()
    {
        $model = $this->model;
        $model = $model::with($this->localizeRelations())->has($this->baseRelation)->onlyTrashed();

        return $model->orderBy($this->sorting_column, $this->sorting_direction)->paginate($this->perPage);
    }

    public function getByFilter($relation)
    {
        $model = $this->model;
        $model = $model::with($this->localizeRelation($relation));

        if ($this->request->has('tags') && !empty(array_diff($tags = explode(',', urldecode($this->request->get('tags'))), ['']))) {
            $model->whereHas($this->baseRelation . '.tags', function ($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            });
        } else {
            $model->has($this->baseRelation);
        }

        if ($this->request->has('country') || $this->request->has('state') || $this->request->has('city') || $this->request->has('category') || $this->request->has('name')) {
            $model->whereHas($relation, function ($query) {
                if ($country = $this->request->get('country'))
                    $query->where('country_id', $country);

                if ($state = $this->request->get('state'))
                    $query->where('state_id', $state);

                if ($city = $this->request->get('city'))
                    $query->where('city_id', $city);

                if ($category = $this->request->get('category'))
                    $query->where('movieable_id', $category);

                if ($name = $this->request->get('name'))
                    $query->where('name', 'like', '%' . $name . '%');
            });
        } else {
            $model->has($relation);
        }

        return $model->orderBy($this->sorting_column, $this->sorting_direction)->get();
    }

    // public function getByFilter($relation)
    // {
    //     $model = $this->model;
    //     $model = $model::with($this->localizeRelation($relation));

    //     if ($this->request->has('tags') && !empty(array_diff($tags = explode(',', urldecode($this->request->get('tags'))), [''])))
    //     {
    //             $model->whereHas($this->baseRelation.'.tags', function ($query) use ($tags) {
    //                 $query->whereIn('tags.id', $tags);
    //             });
    //     }
    //     else {
    //         $model->has($this->baseRelation);
    //     }

    //     if ($this->request->has('country') || $this->request->has('state') || $this->request->has('city') || $this->request->has('category') || $this->request->has('name'))
    //     {
    //         $model->whereHas($relation, function ($query) {
    //             if ($country = $this->request->get('country'))
    //                 $query->where('country_id', $country);

    //             if ($state = $this->request->get('state'))
    //                 $query->where('state_id', $state);

    //             if ($city = $this->request->get('city'))
    //                 $query->where('city_id', $city);

    //             if ($category = $this->request->get('category'))
    //                 $query->where('site_id', $category);

    //             if ($name = $this->request->get('name'))
    //                 $query->where('name', 'like', '%'.$name.'%');
    //         });
    //     }
    //     else {
    //         $model->has($relation);
    //     }

    //     return $model->orderBy($this->sorting_column, $this->sorting_direction)->get();
    // }

    public function getByRelation($relation, $id = null)
    {
        $model = $this->model;
        $model = $model::with([$relation, $this->baseRelation])->has($relation)->has($this->baseRelation);

        if ($id) {
            $model->whereHas($relation, function ($query) use ($relation, $id) {
                $query->where($relation . '.id', $id);
            });
        }

        return $model->orderBy($this->sorting_column, $this->sorting_direction)->paginate($this->perPage);
    }

    public function getChosenByRelation($relation, $choose, $withBaseRelation = false)
    {
        $model = $this->model;
        $model = $model::with($withBaseRelation ? [$relation, $this->baseRelation] : $relation)->has($relation)->has($this->baseRelation);

        $model->whereHas($this->baseRelation, function ($query) use ($choose) {
            $query->where($choose, true);
        });

        return $model->first();
    }

    public function getByFilterRelationValue($filterRelation, $relation, $choose, $value, $withBaseRelation = false)
    {
        $model = $this->model;
        $model = $model::with($withBaseRelation ? [$relation, $this->baseRelation] : $relation)->has($relation)->has($this->baseRelation);

        $model->whereHas($this->baseRelation, function ($query) use ($choose, $value) {
            $query->where($choose, $value);
        });

        return $model->has($filterRelation)->get();
    }

    public function find($id)
    {
        $model = $this->model;
        return $model::find($id);
    }

    public function findTrashed($id)
    {
        $model = $this->model;
        return $model::withTrashed()->where('id', $id)->first();
    }

    public function create($file, $request, $user = null)
    {
        $model = $this->model;
        $file = $model::create($file);
        $relation = $this->getRelation($request, $user);
        //error_log("File Relation:");
        //error_log(print_r($relation));

        // $file->$relation['name']()->attach($relation['id'], [
        //     'created_at' => $file->getAttribute('created_at'),
        //     'updated_at' => $file->getAttribute('updated_at')
        // ]);

        return $file;
    }

    public function delete($id)
    {
        return $this->model::withTrashed()->find($id)->forceDelete();
    }

    public function restore($id)
    {
        $file = $this->findTrashed($id);
        return ($file->trashed()) ? $file->restore() : false;
    }

    public function deleteForever($id)
    {
        $file = $this->findTrashed($id);
        if ($file->trashed()) {
            $this->storageDelete($file);
            return $file->forceDelete();
        }

        return false;
    }

    private function storageDelete($file)
    {
        $fileName = $this->S3[$this->baseRelation] . DIRECTORY_SEPARATOR . $file->name . '.' . $file->ext;

        $storage = \Storage::disk('s3');
        if ($storage->exists($fileName)) {
            $storage->delete($fileName);
        }
    }

    private function localizeRelation($relation)
    {
        $model = array_search($relation, $this->allRelations);
        return method_exists($model, 'localized') ? $relation . '.localized' : $relation;
    }

    private function localizeRelations()
    {
        $relations = [];
        foreach ($this->allRelations as $model => $relation) {
            $relations[] = method_exists($model, 'localized') ? $relation . '.localized' : $relation;
        }
        return $relations;
    }

    public function getRelation($request, $user = null)
    {
        $relationName = strtolower($request['model']);
        $model = array_search($relationName, $this->allRelations);

        if ($user) {
            $relation = ($relationName == 'users') ? $user : $model::find($request['id']);
        } else {
            $relation = $model::find($request['id']);
        }

        if (is_null($relation))
            return false;

        return [
            'id'   => $relation->id,
            'name' => $relationName
        ];
    }
}
