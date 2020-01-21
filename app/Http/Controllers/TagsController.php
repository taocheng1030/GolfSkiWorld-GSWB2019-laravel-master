<?php

namespace App\Http\Controllers;

use App\Models\Tag;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Http\Requests\TagsRequest;

class TagsController extends Controller
{
    use Additional, Resource;

    public function __construct(Tag $model)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(TagsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(TagsRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withModels()
    {
        return [];
    }

    private function save(TagsRequest $request, Tag $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
