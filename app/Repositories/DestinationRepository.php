<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\State;
use App\Models\City;

class DestinationRepository
{
    public $country;
    public $state;
    public $city;

    public function __construct(Country $country, State $state, City $city)
    {
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
    }

    public function getAllCountries()
    {
        $model = $this->country;
        return $model::all();
    }

    public function getCountry($id)
    {
        $model = $this->country;
        return $model::find($id);
    }

    public function getAllStates($country_id = null)
    {
        $model = $this->state;

        if ($country_id) {
            return $model::where('country_id', $country_id)->get();
        }

        return $model::all();
    }

    public function getState($id)
    {
        $model = $this->state;
        return $model::find($id);
    }

    public function getAllCities($state_id = null)
    {
        $model = $this->city;

        if ($state_id) {
            return $model::where('state_id', $state_id)->get();
        }

        return $model::all();
    }

    public function getCity($id)
    {
        $model = $this->city;
        return $model::find($id);
    }
}