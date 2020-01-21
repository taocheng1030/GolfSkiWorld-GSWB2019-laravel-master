<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\User;

class ContactRepository
{
    public $model;
    public $request;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function create($request)
    {

        foreach ($request["contact_id"] as $contact_id) {
            $model = new $this->model;
            $model->setAttribute('user_id', $request["user_id"]);
            $model->setAttribute('contact_id', $contact_id);

            $c = $model->where('user_id', $request["user_id"])->where('contact_id', $contact_id)->get()->first();
            if (!is_null($c)) {
                continue;
            }
            $model->save();
        }

        return true;
    }

    public function get($request)
    {
        $model = $this->model;

        return $model->where('user_id', $request->user_id)->get();
    }

    // public function delete($id)
    // {
    //     return $this->model::withTrashed()->find($id)->forceDelete();
    // }
}
