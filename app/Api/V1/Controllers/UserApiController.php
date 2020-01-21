<?php

namespace App\Api\V1\Controllers;

use App\User;
use App\Models\Device;
use App\Repositories\UserRepository;
use App\Traits\Additional;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    use Helpers, Additional, Controllers, Validation;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth');
        $this->request = $request;
    }

    public function summary()
    {
        User::$pivotHidden = ['user_id', 'follow_id'];
        return [
            'total' => [
                'following' => $this->user->following->count(),
                'followers' => $this->user->followers->count(),
                'liked'     => $this->user->likedFiles->count(),
            ],
            'users' => [
                'following' => $this->user->following,
                'followers' => $this->user->followers,
                'liked'     => $this->user->likedFiles
            ]
        ];
    }

    public function follow()
    {
        $follow = $this->validateCredentials($this->request, [
            'id' => 'required|numeric'
        ]);

        $followTo = User::find($follow['id']);
        if (is_null($followTo))
            return ['status' => false];

        if ($this->user->id == $follow['id'])
            return ['status' => false];

        $following = array_column($this->user->following->toArray(), 'id');
        if (in_array($followTo->id, $following)) {
            $this->user->following()->detach($followTo);
            return ['status' => false];
        }

        $this->user->following()->attach($followTo);
        return ['status' => true];
    }

    public function device()
    {
        $request = $this->validateCredentials($this->request, [
            'device_token' => "required|string",
            'device_type'  => "integer",
            'UDID' => "alpha_num|size:40",
            'user_id' => "integer",
        ]);

        $device = Device::where('device_token', $request['device_token'])->first();
        if (is_null($device)) {
            $device = new Device();
            $device->fill($request);
            $device->user_id = $this->user->id;
            $this->user->devices()->save($device);
            return $device;
        }

        if ($device->user_id != $this->user->id)
            return $this->response->error('This device_token assigned to other user', 500);

        return $device;
    }

    public function subscribe()
    {
        $request = $this->validateCredentials($this->request, [
            'device_token' => "required|string",
            'push' => 'required|boolean'
        ]);

        foreach ($this->user->devices as $device) {
            if ($device->device_token == $request['device_token']) {
                $device->subscribe = $request['push'];
                $device->save();
                return ['status' => true];
            }
        }

        return ['status' => false];
    }

    public function premium(UserRepository $repository)
    {
        $repository->model = $this->user;
        $premium = $repository->setPremium();
        if ($premium->approve == 0 && $premium->suspended == 0 && $premium->status == 0) {
            return ['requested' => $premium->change('request', true)];
        }

        return ['requested' => false];
    }

    public function list()
    {
        // General user role id
        $id = 3;
        $avaiable_users = User::whereDoesntHave('roles')->OrWhereHas('roles', function ($query) use ($id) {
            $query->where('role_id', $id);
        })->get();

        return $avaiable_users;
    }
}
