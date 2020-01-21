<?php

namespace App\Http\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\OtherActivityRequest;
use App\Models\OtherActivity;

class OtherActivitiesController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(OtherActivity $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(OtherActivityRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(OtherActivityRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withModels()
    {
        return [];
    }
    
    private function save(OtherActivityRequest $request, OtherActivity $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
