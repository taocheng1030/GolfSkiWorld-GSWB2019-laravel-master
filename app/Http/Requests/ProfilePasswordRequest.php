<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Authenticatable;

class ProfilePasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Authenticatable $user)
    {
        \Validator::extend('old', function ($attribute, $value, $parameters) use ($user) {
            return \Hash::check($value, $user['password']);
        });

        return [
            'old'              => ['required', 'old'],
            'new'              => ['required', 'min:6', 'max:32', 'confirmed'],
            'new_confirmation' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'old' => 'Old password is incorrect',
        ];
    }
}
