<?php

namespace App\Http\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\DestinfoRequest;
use App\Models\Destinfo;
use App\Models\Photo;

class DestinfosController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Destinfo $model)
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

    public function store(DestinfoRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(DestinfoRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withModels()
    {
        return [];
    }

    private function save(DestinfoRequest $request, Destinfo $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
