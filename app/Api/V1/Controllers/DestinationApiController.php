<?php

namespace App\Api\V1\Controllers;

use App\Models\MediaType;
use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Models\Destination;
use App\Models\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class DestinationApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Destination $destination)
    {
        $this->model = $destination;
    }

    private function validateQuery(Request $request)
    {
        return ['site_id' => $request->get('site'), 'name' => $request->get('name')];
    }

    private function validateRules() {
        return [
            'site'        => 'required|numeric',
            'user'        => 'required',
            'mediatype'   => 'required|numeric',
            'name'        => 'required',
            'description' => 'required',
            'longitude'   => 'required',
            'latitude'    => 'required',
        ];
    }

    private function loadAlways()
    {
        return ['localized'];
    }

    private function loadModels()
    {
        return ['site', 'mediatype'];
    }

    private function withModels()
    {
        return [
            "sites" => Site::all(),
            'mediatypes' => MediaType::all()
        ];
    }

    private function save(Request $request, Destination $model)
    {
        $this->validateApi($request, $model);

        $model->site_id = $request->get('site');
        $model->user_id = $request->get('user');
        $model->mediatype_id = $request->get('mediatype');

        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
