<?php

namespace App\Api\V1\Controllers;

use App\Models\Site;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    use Helpers;

    public function index()
    {
        $model = Site::all();
        if (!$model->count()) {
            return $this->response->error('could not get all', 500);
        }

        return $model->toArray();
    }
}
