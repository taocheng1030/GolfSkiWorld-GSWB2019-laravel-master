<?php

namespace App\Repositories;

use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\Site;
use App\Traits\GeoLocation;

class AccommodationRepository
{
    use GeoLocation;

    public $model;

    public $baseItems;

    public $relations = [
        'site', 'type', 'country', 'state', 'city'
    ];

    public $typeSelector = [
        'site' => [
            'name' => 'site', 'class' => Site::class, 'relation' => 'site', 'field' => 'site_id'
        ],
        'accommodation' => [
            'name' => 'accommodation', 'class' => AccommodationType::class, 'relation' => 'type', 'field' => 'type_id'
        ],
    ];

    public function __construct(Accommodation $accommodation)
    {
        $this->model = $accommodation;
        $this->baseItems = [
            $this->model->getTable().'.id as id', 'site_id', 'type_id', 'longitude', 'latitude', 'name', 'description', 'thumbnail'
        ];
    }
}