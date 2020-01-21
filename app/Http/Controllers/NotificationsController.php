<?php

namespace App\Http\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\NotificationsRequest;
use App\Models\Notification;
use App\Models\Device;

class NotificationsController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Notification $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function store(NotificationsRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'), $model->key);
    }

    public function update(NotificationsRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'), $model->key);
    }

    public function push($id)
    {
        // get tokens
        $tokens = Device::all('device_token')->toArray();
        // get notification
        $model = $this->find($id);
        // create body
        $arrs = [];
        foreach ($tokens as $t) {
            $item = [
                "to" =>  $t['device_token'],
                "title" => $model->name,
                "body" => $model->description,
            ];
            array_push($arrs, $item);
        }
        // send api
        $url = "https://exp.host/--/api/v2/push/send";
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($arrs)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the response
        $responseData = json_decode($response, TRUE);

        return $responseData;
    }

    private function withModels()
    {
        return [];
    }

    private function save(NotificationsRequest $request, Notification $model)
    {
        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
