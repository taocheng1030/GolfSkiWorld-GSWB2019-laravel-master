<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\About;

class AboutApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(About $about)
    {
        $this->model = $about;
    }

    public function index(Request $request)
    {
        $model = $this->model;
        return $model->orderBy('order')->get()->toArray();
    }
}