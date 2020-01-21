<?php

namespace App\Api\V1\Controllers\Auth;

use Config;
use JWTAuth;
use Laravel\Socialite\Facades\Socialite;

use App\User;
use App\Models\Site;
use App\Repositories\UserRepository;
use App\Traits\Validation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use Helpers, Validation;

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        $credentials = $this->validateCredentials($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $token = null;
        try {
            if (!($token = JWTAuth::attempt($credentials))) {
                $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            $this->response->error('could_not_create_token', 500);
        }

        $user = JWTAuth::toUser($token);
        $user->profile->online_status = 1;
        $user->profile->save();

        return $this->generateResponse($user);
    }

    public function signUp(Request $request)
    {
        $userData = $this->validateCredentials($request, [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'sometimes|required|min:6',
        ]);

        $user = $this->repository->create($userData);
        if (!$user)
            return $this->response->error('could_not_create_user', 500);

        return $this->generateResponse($user);
    }

    public function show()
    {
        $user = JWTAuth::parseToken()->toUser();
        $user->profile; // Get user profile object for response, is added to the user object automatically

        return $this->generateResponse($user);
    }

    public function logout()
    {
        $token = JWTAuth::parseToken();

        $user = $token->toUser();
        $user->profile->online_status = 0;
        $user->profile->save();

        $token->invalidate();

        return 'success';
    }

    public function recovery(Request $request)
    {
        $this->validateCredentials($request, [
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(Config::get('boilerplate.recovery_email_subject'));
        });

        switch ($response) 
        {
            case Password::RESET_LINK_SENT:
                return $this->response->noContent();
            default:
                $this->response->errorNotFound();
        }
    }

    public function update(Request $request)
    {
        $this->validateCredentials($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = JWTAuth::parseToken()->toUser();
        if (!$user)
            return $this->response->error('could not update user', 500);

        if ($name = $request->input('name')) 
            $user->name = $name; 
        
        if ($email = $request->input('email')) 
            $user->email = $email;
        
        if ($password = $request->input('password')) 
           $user->password = $password;

        if ($user->save())
            return 'user update success';
    }

    public function facebookLogin(Request $request)
    {
        $this->validateCredentials($request, [
            'facebook_token' => 'required',
            'email' => 'required',
            'name' => 'required',
            'avatar' => 'required',
        ]);

        $facebook = Socialite::driver('facebook')->userFromToken($request->input('facebook_token'));
        if (!$facebook)
            return $this->response->error('could not login with facebook', 500);

        $token = $this->repository->getFbToken($facebook->id);
        if ($token)
        {
            $user = $token->user;
            $user->name = $request->input('name');
            $user->avatar = $request->input('avatar');
            $user->token->facebook_id = $facebook->id;
            $user->token->facebook_token = $facebook->token;
        }
        else
        {
            $user = $this->repository->getUserByEmail($request->input('email'));
            if (!$user)
            {
                $user = $this->repository->create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email')
                ]);

                if (!$user)
                    return $this->response->error('could not login with facebook', 500);
            }

            if ($user->token && $user->token->facebook_id != $facebook->id)
                $user->token->delete();

            $this->repository->model = $user;
            $this->repository->setToken([
                'facebook_id' => $facebook->id,
                'facebook_token' => $facebook->token
            ]);
        }

        if ($user->save())
            return $this->generateResponse($user);
        else
            return $this->response->error('could not login with facebook', 500);
    }

    private function generateResponse(User $user)
    {
        $role = ($user->getRoles() != null) ? $user->roles[0]->slug : "";
        $s3token = ($role != 'banned') ? GetUploadToken() : "";

        $customClaims = ['role' => $role, 's3token' => $s3token];

        $token = JWTAuth::fromUser($user, $customClaims);
        $expiration = JWTAuth::getPayload($token)->get('exp');

        $premium = (isset($user->premium) && $user->premium->status) ? true : false;
        $devices = $user->devices;

        $user->addHidden(['profile', 'premium', 'devices', 'roles']);

        return ['user' => $user, 'profile' => $user->profile, 'token' => $token, 'expiration' => $expiration, 'role' => $role, 'premium' => $premium, 'devices' => $devices, 's3token' => $s3token, 'sites' => Site::all()];
    }
}
