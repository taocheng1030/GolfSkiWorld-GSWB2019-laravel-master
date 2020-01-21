<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Validation;
use App\Traits\Save;
use App\Models\Destinfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Dingo\Api\Routing\Helpers;

class DestinfoApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Destinfo $destinfo)
    {
        $this->model = $destinfo;
    }

    private function withModels()
    {
        return [];
    }

    private function loadModels()
    {
        return ['resorts'];
    }

    private function validateQuery(Request $request)
    {
        return ['name' => $request->get('name')];
    }

    private function validateRules()
    {
        return [
            'name'        => 'required',
            'description' => 'required',
        ];
    }

    private function save(Request $request, Destinfo $model)
    {
        $this->validateApi($request, $model);

        $model->fill($request->all());
        $model->save();

        $this->saveRelations($request, $model, ['resorts'], ',');

        return $model;
    }
}
