<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class AccommodationApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Accommodation $accommodation)
    {
        $this->model = $accommodation;
    }

    public function resorts($type, $id)
    {
        $type = strtolower($type);
        $types = array_map('strtolower', Site::all()->lists('name', 'id')->toArray());
        if (!in_array($type, $types)) {
            return $this->response->error('Type not found', 500);
        }

        $model = $this->find($id);

        $resorts = [];
        foreach ($model->resorts as $resort) {
            if ($resort->site_id == array_search($type, $types))
                $resorts[] = $resort->id;
        }

        return $resorts;
    }

    private function validateQuery(Request $request)
    {
        return ['site_id' => $request->get('site'), 'type_id' => $request->get('type'), 'name' => $request->get('name')];
    }

    private function validateRules() {
        return [
            'site'        => 'required|numeric',
            'type'        => 'required|numeric',
            'name'        => 'required',
            'description' => 'required',
            'owner'       => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'country'     => 'required|numeric',
            'state'       => 'required|numeric',
            'city'        => 'required|numeric',
            'street'      => 'required',
            'zip'         => 'required',
            'phone'       => 'required',
            'email'       => 'required|email',
            'link'        => 'required',
        ];
    }

    private function loadAlways()
    {
        return ['localized'];
    }

    private function loadModels()
    {
        return ['site', 'type', 'country', 'state', 'city'];
    }

    private function withModels()
    {
        return [
            'types' => Site::all(),
            "sites" => AccommodationType::all()
        ];
    }

    private function save(Request $request, Accommodation $model)
    {
        $this->validateApi($request, $model);

        $model->site_id = $request->get('site');
        $model->type_id = $request->get('type');
        $model->country_id = $request->get('country');
        $model->state_id = $request->get('state');
        $model->city_id = $request->get('city');

        $model->sponser = $this->boolean($request, 'sponser');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        $this->saveRelations($request, $model, ['resorts'], ',');

        return $model;
    }
}
