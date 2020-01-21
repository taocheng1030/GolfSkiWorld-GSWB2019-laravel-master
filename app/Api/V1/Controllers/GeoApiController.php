<?php

namespace App\Api\V1\Controllers;

use App\Repositories\DealRepository;
use App\Repositories\LastminuteRepository;
use App\Repositories\ResortRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\AccommodationRepository;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Traits\Validation;
use App\Models\Resort;
use Illuminate\Support\Facades\DB;

class GeoApiController extends Controller
{
    use Validation, Helpers;

    private $repositories = [];

    public function __construct(DealRepository $deal, LastminuteRepository $lastminute, ResortRepository $resort, AccommodationRepository $accommodation, RestaurantRepository $restaurant)
    {
        $this->repositories['deal'] = $deal;
        $this->repositories['lastminute'] = $lastminute;
        $this->repositories['resort'] = $resort;
        $this->repositories['accommodation'] = $accommodation;
        $this->repositories['restaurant'] = $restaurant;
    }

    private function getNames()
    {
        $names = [];
        foreach ($this->repositories as $key => $repository) {
            $names[] = $this->repositories[$key]->model->getModelName();
        }

        return $names;
    }

    private function assign($array)
    {
        foreach ($array as $key => $item) {
            $array[$key]['url'] = substr(action('\App\Api\V1\Controllers\GeoApiController@show', ['model' => $item['model'], 'id' => $item['id']], false), 4);
        }

        return $array;
    }

    /*
     * Actions
     */

    public function index(Request $request)
    {
        $geo = [];

        foreach ($this->getNames() as $name) {
            $repository = $this->assign(
                $this->repositories[$name]->byCoordinates($request)
            );
            $geo = array_merge($geo, $repository);
        }

        return $geo;
    }

    public function nearResorts(Request $request)
    {
        $latLong = $this->validateCredentials($request, [
            'lat'   => 'required|numeric',
            'long'  => 'required|numeric',
            'count' => 'required|numeric',
            'id'    => 'required|numeric',
        ]);

        $radius = 250; // Km
        $resorts = Resort::selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) as distance", [$latLong['lat'], $latLong['long'],  $latLong['lat']])
            ->where('id', '<>', $latLong['id'])
            ->where('published', true)
            ->havingRaw('distance < ?', [$radius])
            ->orderBy('distance')->limit($latLong['count'])->get()->toArray();

        // $angle_radius = abs($radius / (111 * cos($latLong['lat'])));

        // $min_lon = $latLong['long'] - $angle_radius;
        // $max_lon = $latLong['long'] + $angle_radius;
        // $min_lat = $latLong['lat'] - $angle_radius;
        // $max_lat = $latLong['lat'] + $angle_radius;

        // $array = Resort::where('id', '<>', $latLong['id'])
        //     ->where('published', true)
        //     ->where('longitude', '>=', $min_lon)
        //     ->where('longitude', '<=', $max_lon)
        //     ->where('latitude',  '>=', $min_lat)
        //     ->where('latitude',  '<=', $max_lat)
        //     ->limit($latLong['count'])
        //     ->get()
        //     ->toArray();

        return $resorts;
    }

    public function show($model, $id)
    {
        if (!in_array($model, $this->getNames())) {
            return $this->response->error('Model not found', 500);
        }

        $model = $this->repositories[$model]->find($id);
        if (!$model)
            return $this->response->error('Not published', 500);

        return $model->toArray();
    }

    public function filterCategories()
    {
        $categories = [];

        foreach ($this->getNames() as $name) {
            $repository = $this->repositories[$name]->getTypes();
            $categories = array_merge($categories, $repository);
        }

        // 2 раза пооврачиваем массив, убираем лишнее
        $ids = array_flip(array_flip(array_column($categories, 'id')));
        $names = array_flip(array_flip(array_column($categories, 'name')));

        $items = [];
        foreach ($ids as $key => $id) {
            $items[] = [
                'id' => $id,
                'name' => $names[$key],
            ];
        }

        return $items;
    }


    private function getAmadeusToken()
    {
        $curl = curl_init();
        $headers[] = 'Content-type: application/x-www-form-urlencoded;';
        $data = array(
            "grant_type" => "client_credentials",
            "client_id" => config('amadeus.api_key'),
            "client_secret" => config('amadeus.api_secret')
        );
        $url = config('amadeus.api_url') . 'security/oauth2/token';
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($result);
        $access_token = $response->access_token;

        return $access_token;
    }

    public function airports(Request $request)
    {
        $latLong = $this->validateCredentials($request, [
            'lat' => 'required|numeric',
            'long'  => 'required|numeric',
            'count'   => 'required|numeric',
        ]);

        $access_token = $this->getAmadeusToken();

        $curl = curl_init();
        $headers[] = 'Authorization: Bearer ' . $access_token;
        $url = config('amadeus.api_url') . 'reference-data/locations/airports';
        $data = array(
            "latitude" => $latLong['lat'],
            "longitude" => $latLong['long'],
            "page[limit]" => $latLong['count'],
            'sort' => 'distance'
        );
        $url = sprintf("%s?%s", $url, http_build_query($data));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($result);
        return [
            "data" => $response->data,
            "marker" => config('photo.marker.path') . 'airport' . config('photo.marker.ext')
        ];
    }

    public function search(Request $request)
    {
        $host = config('amadeus.travel_url');

        $params = $this->validateCredentials($request, [
            'origin' => 'required|string',
            'destination'  => 'required|string',
            'locale' => 'required|string',
            'adults' => 'required|numeric',
            'children' => 'required|numeric',
            'currency'   => 'required|string',
            'departure_date'   => 'required|string',
            'return_date'   => 'required|string',
            'number_of_results'   => 'required|numeric',
        ]);

        $query = array(
            'affiliate_key' => config('amadeus.travel_api_key'),
            'origin' => $params['origin'],
            'destination' => $params['destination'],
            'locale' =>  $params['locale'],
            'adults' => $params['adults'],
            'children' => $params['children'],
            'infants' => 0,
            'seniors' => 0,
            'travel_class' => 'ECONOMY',
            'currency' => $params['currency'],
            'include_merchants' => '*',
            'non_stop' => 'false',
            'platform' => 'web',
            'preferred_landing_page' => 'search_results',
            'flow' => 'SEARCH',
            'disable_deep_links' => 'false',
            'departure_date' => $params['departure_date'],
            'return_date' => $params['return_date'] != $params['departure_date'] ? $params['return_date'] : "",
            'number_of_results' => $params['number_of_results']
        );

        $ch = curl_init($host . 'api/search/?' . http_build_query($query));
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            )
        ));

        // Send the request
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, TRUE);
        return $result;
    }

    public function locations(Request $request)
    {
        $params = $this->validateCredentials($request, [
            'keyword' => 'required|string',
        ]);
        $keyword = $params['keyword'];

        $query = array(
            'subType' => 'AIRPORT,CITY',
            'keyword' => $keyword,
            'page[limit]' => 20,
        );

        $access_token = $this->getAmadeusToken();

        $ch = curl_init(config('amadeus.api_url') . 'reference-data/locations?' . http_build_query($query));
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token,
            ),
        ));

        // Send the request
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, TRUE);
        return $result;
    }
}
