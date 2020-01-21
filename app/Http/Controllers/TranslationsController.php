<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Translation;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Http\Requests\TranslationsRequest;

class TranslationsController extends Controller
{
    use Additional, Resource;

    public function __construct(Translation $model)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(TranslationsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'), $model->key);
    }

    public function update(TranslationsRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'), $model->key);
    }

    private function withFilterScopes()
    {
        return [
            'joinLanguage'
        ];
    }

    private function withModels()
    {
        return [
            'languages' => Language::all()
        ];
    }

    private function save(TranslationsRequest $request, Translation $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
