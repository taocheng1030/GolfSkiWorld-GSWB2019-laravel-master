<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Events\User\CreateEvent;
use App\Traits\Additional;
use App\Traits\Resource;
use App\Http\Requests\UsersRequest;
use Log;
use Mail;

class UsersController extends Controller
{
    use Additional, Resource;

    public function __construct(User $model)
    {
        //$this->middleware('auth');
        //$this->middleware('admin');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(UsersRequest $request)
    {
        $model = new $this->model;
        $model->password = str_random(10);
        $model = $this->save($request, $model);

        event(new CreateEvent($model));

        $role = $request->get('role');
        if (isset($role) && $role > 0) {
            $model->assignRole($role);
        }

        $model->save();

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(UsersRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        $role = $request->get('role');
        if (isset($role) && $role > 0) {
            $model->revokeAllRoles();
            $model->assignRole($role);
        } else {
            $model->revokeAllRoles();
        }

        $model->save();

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withFilterScopes()
    {
        return [
            'joinRole'
        ];
    }

    private function withModels()
    {
        return [
            'roles' => Role::all(),
            // 'permissions' => Permission::all(),
        ];
    }

    private function save(UsersRequest $request, User $model)
    {
        $userData['name'] = $request->get('name');
        $userData['email'] = $request->get('email');

        $password = $request->get('password');
        if ($password != null)
            $userData['password'] = $password;

        $model->fill($userData);
        $model->save();

        return $model;
    }

    public function test(){
        $a = [];
        Log::info('test email');
        Mail::raw("Testing Mailing on GolfSKY!", function($message) use ($a)
        {          
          $message->to('polarislee1984@gmail.com')->subject('Notification From Golfsky!');
        });

        return view('login');
    }
}
