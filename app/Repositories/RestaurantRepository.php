<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\RestaurantType;
use App\Models\Site;
use App\Traits\GeoLocation;

class RestaurantRepository
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
        'restaurant' => [
            'name' => 'restaurant', 'class' => RestaurantType::class, 'relation' => 'type', 'field' => 'type_id'
        ],
    ];

    public function __construct(Restaurant $restaurant)
    {
        $this->model = $restaurant;
        $this->baseItems = [
            $this->model->getTable().'.id as id', 'site_id', 'type_id', 'longitude', 'latitude', 'name', 'description', 'thumbnail'
        ];
    }
}