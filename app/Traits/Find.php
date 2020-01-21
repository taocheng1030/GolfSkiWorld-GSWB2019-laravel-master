<?php
namespace App\Traits;

trait Find
{
    /*
    * Get multiple elements
    */

    public function getAll()
    {
        $model = $this->model;
        return $model::all();
    }

    public function getByIds($ids, $relations = [])
    {
        $model = $this->model;
        return $model::with($relations)->whereIn('id', $ids)->get();
    }



    /*
    * Find single element
    */

    public function find($id)
    {
        $model = $this->model;
        return $model::find($id);
    }

    public function findByKey($key, $value)
    {
        $model = $this->model;
        return $model::where($key, $value)->first();
    }

    public function findPublished($id)
    {
        $model = $this->model;
        return $model::where('published', true)->where('id', $id)->first();
    }
}