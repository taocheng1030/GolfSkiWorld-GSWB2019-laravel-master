<?php

namespace App\Http\Controllers;

use App\Models\Destination;

use App\Traits\Additional;

class DestinationsController extends Controller
{
    use Additional;

    public function __construct(Destination $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;
    }
}
