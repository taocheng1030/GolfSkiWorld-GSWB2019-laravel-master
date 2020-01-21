<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Requests\ProfilePasswordRequest;
use App\Traits\Additional;
use App\Traits\Save;
use App\Traits\Validation;
use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use Additional, Save, Validation;

    private $summaryTypes = [
        'followers' => 'My followers',
        'following' => 'Following users',
        'liked' => 'Liked items'
    ];

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['check']]);
        $this->request = $request;
        $this->model = Auth::user();
    }

    public function show()
    {
        return view('profile.index', [
            'user' => $this->model
        ]);
    }

    public function save(ProfileRequest $request)
    {
        $user = $this->model;

        $userData['name'] = $request->get('name');
        $userData['email'] = $request->get('email');

        $user->fill($userData);
        $user->save();

        $profile = $user->profile;
        $profile->fill($request->all());

        $profile->newsletter = $this->boolean($request, 'newsletter');
        $profile->notify = $this->boolean($request, 'notify');
        $profile->save();

        return statusTrue(['message' => 'Your profile successfully updated']);
    }

    public function password(ProfilePasswordRequest $request)
    {
        $this->model->password = $request->get('new');
        $this->model->save();

        return statusTrue(['clear' => true, 'message' => 'Your password successfully changed']);
    }

    public function summary($type)
    {
        if (array_key_exists($type, $this->summaryTypes) === false)
            return statusFalse();

        if ($type != 'liked') {
            $summary = $this->model->$type->each(function ($row) {
                $row->addHidden(['pivot']);
            });

            return statusTrue(['title' => $this->summaryTypes[$type], 'items' => $summary]);
        }
    }

    public function check()
    {
        return ['status' => Auth::check(), 'id' => Auth::id()];
    }
}
