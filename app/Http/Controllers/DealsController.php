<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealLimiter;
use App\Models\Site;
use App\Models\Resort;
use App\Models\Accommodation;
use App\Models\Restaurant;
use App\Models\Photo;
use App\Models\Video;
use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Models\File;
use App\Http\Requests\DealsRequest;

class DealsController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Deal $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(DealsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(DealsRequest $request, $id)
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
                'table' => DealLimiter::tableName()
            ]
        ];
    }

    private function withModels()
    {
        return [
            'limiters' => DealLimiter::all(),
            'sites' => Site::all(),
            'resorts' => Resort::with('site')->get()->lists('nameWithSite', 'id'),
            'restaurants' => Restaurant::with('site')->get()->lists('nameWithSite', 'id'),
            'accommodations' => Accommodation::with('site')->get()->lists('nameWithSite', 'id'),
            'photos' => Photo::where('imageable_type', $this->getClassModel($this->modelName(true, true)))->get(),
            'videos' => Video::where('movieable_type', $this->getClassModel($this->modelName(true, true)))->get(),
        ];
    }

    private function save(DealsRequest $request, Deal $model)
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
