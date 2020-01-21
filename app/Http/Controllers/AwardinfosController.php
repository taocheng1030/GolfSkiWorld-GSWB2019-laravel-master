<?php

namespace App\Http\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\AwardinfosRequest;
use App\Models\Awardinfo;
use App\Models\Photo;

class AwardinfosController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Awardinfo $model)
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

    public function store(AwardinfosRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'), $model->key);
    }

    public function update(AwardinfosRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'), $model->key);
    }

    private function withModels()
    {
        return [];
    }

    private function save(AwardinfosRequest $request, Awardinfo $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
