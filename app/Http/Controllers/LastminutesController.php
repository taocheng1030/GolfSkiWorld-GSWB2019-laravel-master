<?php

namespace App\Http\Controllers;

use App\Models\Lastminute;
use App\Models\LastminuteLimiter;
use App\Models\Site;
use App\Models\Resort;
use App\Models\Accommodation;
use App\Models\Restaurant;
use App\Models\Photo;
use App\Models\Video;
use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\LastminutesRequest;

class LastminutesController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Lastminute $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(LastminutesRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(LastminutesRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withFilterScopes()
    {
        return [
            'joinSite',
            [
                'scope' => 'joinLimiter',
                'table' => LastminuteLimiter::tableName()
            ]
        ];
    }

    private function withModels()
    {
        return [
            'limiters' => LastminuteLimiter::all(),
            'sites' => Site::all(),
            'resorts' => Resort::with('site')->get()->lists('nameWithSite', 'id'),
            'restaurants' => Restaurant::with('site')->get()->lists('nameWithSite', 'id'),
            'accommodations' => Accommodation::with('site')->get()->lists('nameWithSite', 'id'),
            'photos' => Photo::where('imageable_type', $this->getClassModel($this->modelName(true, true)))->get(),
            'videos' => Video::where('movieable_type', $this->getClassModel($this->modelName(true, true)))->get()
        ];
    }

    private function save(LastminutesRequest $request, Lastminute $model)
    {
        $model->site_id = $request->get('site_id');
        $model->limiter_id = implode(",", $request->get('limiter_id'));
        $model->email = $this->boolean($request, 'email');
        $model->sms = $this->boolean($request, 'sms');
        $model->push = $this->boolean($request, 'push');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        $this->saveLocal($request, $model);

        $this->saveRelations($request, $model, ['resorts', 'restaurants', 'accommodations']);

        $this->sendNotifications($model);

        return $model;
    }
}
