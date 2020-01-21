<?php

namespace App\Http\Requests;

class ProfileRequest extends Request
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
    public function rules()
    {
        $user = \Auth::user();
        return [
            'name'      => ['required', "unique:users,name,{$user->id}"],
            'email'     => ['required', 'email', "unique:users,email,{$user->id}"],
            'firstname' => ['required'],
            'lastname'  => ['required'],
            'address'   => ['required', "unique:profiles,address,{$user->profile->id}"],
            'zip'       => ['required'],
            'phone'     => ['required', "unique:profiles,phone,{$user->profile->id}"],
        ];
    }
}
