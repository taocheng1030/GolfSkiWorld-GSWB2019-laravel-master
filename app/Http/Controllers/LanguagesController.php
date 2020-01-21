<?php

namespace App\Http\Controllers;

use App\Models\Language;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Http\Requests\LanguagesRequest;

class LanguagesController extends Controller
{
    use Additional, Resource;

    public function __construct(Language $model)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(LanguagesRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(LanguagesRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withModels()
    {
        return [];
    }

    private function save(LanguagesRequest $request, Language $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
