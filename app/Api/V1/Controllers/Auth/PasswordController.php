<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use Helpers, ResetsPasswords;

    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
        self::$isApi = true;
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            $this->response->errorBadRequest();
        }

        return [
            'status' => true,
            'token' => $token,
            'email' => $request->input('email')

        ];
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password
        ])->save();
    }

    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return [
            'status' => true,
            'message' => trans($response)
        ];
    }

    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return [
            'status' => false,
            'message' => trans($response)
        ];
    }

    protected function getResetSuccessResponse($response)
    {
        return [
            'status' => true,
            'message' => trans($response)
        ];
    }

    protected function getResetFailureResponse(Request $request, $response)
    {
        return [
            'status' => false,
            'message' => trans($response)
        ];
    }
}
