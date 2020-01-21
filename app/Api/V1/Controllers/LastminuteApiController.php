<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Models\Lastminute;
use App\Models\LastminuteLimiter;
use App\Models\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class LastminuteApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Lastminute $lastminute)
    {
        $this->model = $lastminute;
    }

    private function validateQuery(Request $request)
    {
        return ['site_id' => $request->get('site'), 'name' => $request->get('name')];
    }

    private function validateRules() {
        return [
            'site'              => 'required|numeric',
            'limiter'           => 'required|numeric',
            'name'              => 'required',
            'shortdescription'  => 'required',
            'description'       => 'required',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'originalprice'     => 'required',
            'price'             => 'required',
            'currency'          => 'required',
            'link'              => 'required',
            'owner'             => 'required',
            'starts'            => 'required',
            'ends'              => 'required',
            'numberofpurchases' => 'required|numeric',
        ];
    }

    private function loadAlways()
    {
        return ['localized'];
    }

    private function loadModels()
    {
        return ['site', 'photos', 'limiter', 'resorts', 'restaurants', 'accommodations'];
    }

    private function withModels()
    {
        return [
            'sites' => Site::all(),
            'limiters' => LastminuteLimiter::all()
        ];
    }

    private function save(Request $request, Lastminute $model)
    {
        $this->validateApi($request, $model);

        $model->site_id = $request->get('site');
        $model->limiter_id = $request->get('limiter');

        $model->email = $this->boolean($request, 'email');
        $model->sms = $this->boolean($request, 'sms');
        $model->push = $this->boolean($request, 'push');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        $this->saveLocal($request, $model);

        $this->saveRelations($request, $model, ['resorts', 'restaurants', 'accommodations'], ',');

        return $model;
    }
}
