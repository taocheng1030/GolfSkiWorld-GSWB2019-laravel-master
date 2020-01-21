<?php

namespace App\Api\V1\Controllers;

use App\Repositories\DestinationRepository;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class CountryStateCityController extends Controller
{
    use Helpers;

    private $repository;

    public function __construct(DestinationRepository $destination)
    {
        $this->repository = $destination;
    }

    public function countries()
    {
        return $this->repository->getAllCountries()->toArray();
    }

    public function country($id)
    {
        $model = $this->repository->getCountry($id);
        if (!$model) {
            return $this->response->error('Could not get country', 500);
        }

        return $model->toArray();
    }

    public function states($country_id = null)
    {
        return $this->repository->getAllStates($country_id)->toArray();
    }

    public function state($id)
    {
        $model = $this->repository->getState($id);
        if (!$model) {
            return $this->response->error('Could not get state', 500);
        }

        return $model->toArray();
    }

    public function cities($state_id = null)
    {
        return $this->repository->getAllCities($state_id)->toArray();
    }

    public function city($id)
    {
        $model = $this->repository->getCity($id);
        if (!$model) {
            return $this->response->error('Could not get city', 500);
        }

        return $model->toArray();
    }
}
