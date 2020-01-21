<?php

namespace App\Http\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\AboutsRequest;
use App\Models\About;
use App\Models\Photo;

class AboutsController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(About $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function edit($id)
    {
        $model = $this->find($id);

        return $this->view('edit', [
            'model' => $model,
            'photos' => Photo::where('imageable_type', $this->getClassModel($this->modelName(true, true)))->get(),
        ]);
    }

    public function store(AboutsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'), $model->key);
    }

    public function update(AboutsRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'), $model->key);
    }

    private function withModels()
    {
        return [];
    }

    private function save(AboutsRequest $request, About $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
