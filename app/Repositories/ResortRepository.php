<?php

namespace App\Repositories;

use App\Models\Resort;
use App\Models\Site;
use App\Traits\GeoLocation;

class ResortRepository
{
    use GeoLocation;

    public $model;

    public $baseItems;

    public $relations = [
        'site', 'country', 'state', 'city'
    ];

    public $typeSelector = [
        'site' => [
            'name' => 'site', 'class' => Site::class, 'relation' => 'site', 'field' => 'site_id'
        ],
    ];

    public function __construct(Resort $resort)
    {
        $this->model = $resort;
        $this->baseItems = [
            $this->model->getTable().'.id as id', 'site_id', 'longitude', 'latitude', 'name', 'description', 'thumbnail'
        ];
    }
}