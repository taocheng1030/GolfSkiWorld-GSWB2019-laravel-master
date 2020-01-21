<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Traits\Validation;
use App\Models\Resort;
use App\Models\Site;
use App\Models\Destinfo;
use App\Models\Photo;
use App\Models\Shares;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class ResortApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save;

    public function __construct(Resort $resort)
    {
        $this->model = $resort;
    }

    public function deals($id)
    {
        $model = $this->find($id);
        return $model->deals;
    }

    public function lastminutes($id)
    {
        $model = $this->find($id);
        return $model->lastminutes;
    }

    public function restaurants($id)
    {
        $model = $this->find($id);
        return $model->restaurants;
    }

    public function accommodations($id)
    {
        $model = $this->find($id);
        return $model->accommodations;
    }

    private function validateQuery(Request $request)
    {
        return ['site_id' => $request->get('site'), 'name' => $request->get('name')];
    }

    private function validateRules()
    {
        return [
            'site'        => 'required|numeric',
            'name'        => 'required',
            'description' => 'required',
            'details'     => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'country'     => 'required|numeric',
            'state'       => 'required|numeric',
            'city'        => 'required|numeric',
            'street'      => 'required',
            'zip'         => 'required',
            'phone'       => 'required',
            'email'       => 'required|email',
            'link'        => 'required',
        ];
    }

    private function loadAlways()
    {
        return ['localized'];
    }

    private function loadModels()
    {
        return ['site', 'country', 'state', 'city', 'deals', 'lastminutes', 'restaurants', 'accommodations', 'destinfos'];
    }

    private function withModels()
    {
        return [
            "sites" => Site::all()
        ];
    }

    private function save(Request $request, Resort $model)
    {
        $this->validateApi($request, $model);

        $model->site_id = $request->get('site');
        $model->country_id = $request->get('country');
        $model->state_id = $request->get('state');
        $model->city_id = $request->get('city');

        $model->sponser = $this->boolean($request, 'sponser');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        $this->saveRelations($request, $model, ['restaurants', 'accommodations'], ',');

        return $model;
    }


    private function getISO($lat, $lng)
    {
        $host = config('arrivalguide.url');

        $params = array(
            'auth' => config('arrivalguide.auth'),
            'lat' => $lat,
            'lng' => $lng,
            'limit' => 1,
            'maxDistance' => 100000
        );
        $ch = curl_init($host . '/TravelguideByLocation?' . http_build_query($params));
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            )
        ));
        // Send the request
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($response); // where $xml_string is the XML data you'd like to use (a well-formatted XML string). If retrieving from an external source, you can use file_get_contents to retrieve the data and populate this variable.
        $json = json_encode($xml); // convert the XML string to JSON
        $array = json_decode($json, TRUE); // convert the JSON-encoded string to a PHP variable

        if (sizeof($array)) {
            return $array['@attributes']['iso'];
        }

        return null;
    }

    private function getArrivalguideDestination($iso)
    {
        $host = config('arrivalguide.url');

        $params = array(
            'auth' => config('arrivalguide.auth'),
            'lang' => 'en',
            'iso' => $iso,
            'v' => config('arrivalguide.version')
        );
        $ch = curl_init($host . '/Travelguide?' . http_build_query($params));
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            )
        ));
        // Send the request
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($response); // where $xml_string is the XML data you'd like to use (a well-formatted XML string). If retrieving from an external source, you can use file_get_contents to retrieve the data and populate this variable.
        $json = json_encode($xml); // convert the XML string to JSON
        $array = json_decode($json, TRUE); // convert the JSON-encoded string to a PHP variable

        return $array;
    }

    public function edit($id)
    {
        $model = $this->find($id);
        if (!sizeof($model->destinfos)) {
            $iso = $this->getISO($model->latitude, $model->longitude);

            if ($iso != null) {
                $destination = $this->getArrivalguideDestination($iso);
                $model->ag_destinfo = $destination;
            }
        }

        return array_merge([
            $this->modelName() => $model,
        ], $this->withModels());
    }

    public function destinfo($id)
    {
        $model = $this->find($id);
        $destinfos = $model->destinfos->all();

        return [
            "data" => $destinfos
        ];
    }

    public function agDestinfo(Request $request)
    {
        $latLong = $this->validateCredentials($request, [
            'lat' => 'required|numeric',
            'long'  => 'required|numeric',
        ]);

        $iso = $this->getISO($latLong['lat'], $latLong['long']);
        if ($iso != null) {
            $destination = $this->getArrivalguideDestination($iso);
            return $destination;
        }

        return null;
    }
}
