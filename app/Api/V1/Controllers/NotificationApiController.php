<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\Additional;
use App\Traits\Controllers;
use App\Traits\Validation;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Device;

class NotificationApiController extends Controller
{
    use Helpers, Additional, Controllers, Validation;

    function __construct(Request $request)
    {
        $this->middleware('jwt.auth');
        $this->request = $request;
    }

    public function sns()
    {
        return ['status' => true];
    }

    public function sms()
    {
        return ['status' => true];
    }

    public function chat()
    {
        $request = $this->validateCredentials($this->request, [
            'is_image' => "boolean",
            'image_url'  => "string",
            'is_video' => "boolean",
            'video_url' => "string",
            'message' => "string",
            'receiver_id' => "required|int"
        ]);

        $device = Device::where('user_id', $request["receiver_id"])->first();
        if (is_null($device)) {
            $this->response->errorBadRequest();
        }

        $arrs = [];
        $item = [
            "to" =>  $device->device_token,
            "body" => $request["message"],
        ];
        array_push($arrs, $item);

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
}
