<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\City;
use App\Models\Premium;
use App\Models\Profile;
use App\Models\Token;
use App\User;

use App\Events\User\CreateEvent;

class UserRepository
{
    public $model;
    public $profile;
    public $premium;
    public $token;

    public function __construct(User $model, Profile $profile, Premium $premium, Token $token)
    {
        $this->model = $model;
        $this->profile = $profile;
        $this->premium = $premium;
        $this->token = $token;
    }

    public function create(array $request)
    {
        if (!isset($request['password']))
            $request['password'] = str_random(10);

        $model = $this->model;
        $model::unguard();
        $user = $model::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password']
        ]);
        $model::reguard();

        event(new CreateEvent($user, $request, true));

        return $user;
    }

    public function setProfile(array $request)
    {
        $country = array_exist($request, 'country');
        $country = Country::where(is_numeric($country) ? 'id' : 'name', $country)->first();

        $city = array_exist($request, 'city');
        $city = City::where(is_numeric($city) ? 'id' : 'name', $city)->first();

        $profile = $this->profile->fill([
            'language_id' => array_exist($request, 'language', 1),
            'country_id' => object_exist($country, 'id', 1),
            'state_id' => object_exist($city, 'state_id', 1),
            'city_id' => object_exist($city, 'id', 1),
            'firstname' => array_exist($request, 'firstname', ""),
            'lastname' => array_exist($request, 'lastname', ""),
            'address' => array_exist($request, 'address', ""),
            'zip' => array_exist($request, 'zip', ""),
            'phone' => array_exist($request, 'phone', ""),
            'newsletter' => array_exist($request, 'newsletter', ""),
            'notify' => array_exist($request, 'notify', ""),
            'online_status' => array_exist($request, 'online_status', 1),
            'show_info' => array_exist($request, 'show_info', 1),
            'priority' => array_exist($request, 'priority', 1)
        ]);
        $this->model->profile()->save($profile);

        return $profile;
    }

    public function setPremium(array $attributes = [])
    {
        $user = $this->model;

        if ($user->premium)
            return $user->premium;

        $premium = $this->premium->fill($attributes);
        $this->model->premium()->save($premium);

        return $premium;
    }

    public function setToken(array $attributes = [])
    {
        $token = $this->token->fill($attributes);
        $this->model->token()->save($token);

        return $token;
    }

    public function getFbToken($facebook_id)
    {
        return $this->token->where('facebook_id', $facebook_id)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}