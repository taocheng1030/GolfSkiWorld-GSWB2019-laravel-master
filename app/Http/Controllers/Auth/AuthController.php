<?php

namespace App\Http\Controllers\Auth;

use Validator;

use App\Models\Language;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

use App\Repositories\UserRepository;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected $repository;

    /**
     * Create a new authentication controller instance.
     *
     * @param  UserRepository  $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);

        $this->repository = $repository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'language' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'phone' => 'required',
        ]);
    }
    
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register', [
            'languages' => Language::all(),
            'countries' => Country::all(),
            'states' => State::where('country_id', old('country'))->get(),
            'cities' => City::where('state_id', old('state'))->get(),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return  UserRepository
     */
    protected function create(array $data)
    {
        return $this->repository->create($data);
    }
}
