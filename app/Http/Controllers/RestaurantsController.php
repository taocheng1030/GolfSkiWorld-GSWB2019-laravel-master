<?php

namespace App\Http\Controllers;

use App\Domains\SidebarControl;
use App\Models\Restaurant;
use App\Models\RestaurantType;
use App\Models\Resort;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Site;
use App\Models\Photo;
use App\Models\Video;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\RestaurantsRequest;

class RestaurantsController extends Controller
{
    use Additional, Resource, Save, \App\Traits\SidebarControl;

    public function __construct(Restaurant $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();

        self::$sidebarControl = SidebarControl::make($this->controllerName(), 'admin.restaurant.sidebar')->setModels([
            RestaurantType::class => [
                'title'  => 'Restaurant types',
                'fields' => [
                    'name' => 'required|string|unique:' . (new RestaurantType())->getTable()
                ]
            ]
        ])->filterPages([
            'index'
        ]);
    }

    public function create()
    {
        return $this->view('create', [
            'sites' => Site::all(),
            'types' => RestaurantType::all(),
            'resorts' => Resort::with('site')->get()->lists('nameWithSite', 'id'),
            'countries' => Country::all(),
            'states' => State::where('country_id', old('country_id'))->get(),
            'cities' => City::where('state_id', old('state_id'))->get(),
        ]);
    }

    public function edit($id)
    {
        $model = $this->find($id);

        $country_id = old('country_id') ? old('country_id') : $model->country_id;
        $state_id = old('state_id') ? old('state_id') : $model->state_id;

        return $this->view('edit', [
            'model' => $model,
            'sites' => Site::all(),
            'types' => RestaurantType::all(),
            'resorts' => Resort::with('site')->get()->lists('nameWithSite', 'id'),
            'countries' => Country::all(),
            'states' => State::where('country_id', $country_id)->get(),
            'cities' => City::where('state_id', $state_id)->get(),
            'photos' => Photo::where('imageable_type', $this->getClassModel($this->modelName(true, true)))->get(),
            'videos' => Video::where('movieable_type', $this->getClassModel($this->modelName(true, true)))->get()
        ]);
    }

    public function store(RestaurantsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(RestaurantsRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withFilterScopes()
    {
        return [
            'joinSite',
            'joinLocation',
            [
                'scope' => 'joinType',
                'table' => RestaurantType::tableName()
            ]
        ];
    }

    private function save(RestaurantsRequest $request, Restaurant $model)
    {
        $model->site_id = $request->get('site_id');
        $model->type_id = $request->get('type_id');

        $model->country_id = $request->get('country_id');
        $model->state_id = $request->get('state_id');
        $model->city_id = $request->get('city_id');

        $model->sponser = $this->boolean($request, 'sponser');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        $this->saveLocal($request, $model);

        $this->saveRelations($request, $model, ['resorts']);

        return $model;
    }
}
