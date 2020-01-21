<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Awardinfo;

class AwardinfoApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Awardinfo $awardinfo)
    {
        $this->model = $awardinfo;
    }

    public function index(Request $request)
    {
        $model = $this->model;
        return $model->get()->toArray()[0];
    }
}