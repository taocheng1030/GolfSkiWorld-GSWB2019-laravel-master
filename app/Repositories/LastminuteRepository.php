<?php

namespace App\Repositories;

use App\Models\Lastminute;
use App\Models\Site;
use App\Traits\GeoLocation;

class LastminuteRepository
{
    use GeoLocation;

    public $model;

    public $baseItems;

    public $relations = [
        'site', 'limiter'
    ];

    public $typeSelector = [
        'site' => [
            'name' => 'site', 'class' => Site::class, 'relation' => 'site', 'field' => 'site_id'
        ],
    ];

    public function __construct(Lastminute $resort)
    {
        $this->model = $resort;
        $this->baseItems = [
            $this->model->getTable().'.id as id', 'site_id', 'longitude', 'latitude', 'name', 'shortdescription', 'thumbnail'
        ];
    }
}