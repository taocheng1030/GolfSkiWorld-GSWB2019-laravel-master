<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Device;

class DeviceApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Device $device)
    {
        $this->model = $device;
    }

    public function index(Request $request)
    {
        $model = $this->model;
        return $model->get()->toArray();
    }

    private function validateQuery(Request $request)
    {
        return [
            'device_token' => $request->get('device_token'),
            'device_type' => $request->get('device_type'),
            'UDID' => $request->get('UDID')
        ];
    }

    private function validateRules()
    {
        return [];
    }

    public function save(Request $request, Device $model)
    {
        // $this->validateApi($request, $model);
        $model->fill($request->all());  
        $model->save();

        return $model;
    }
}
