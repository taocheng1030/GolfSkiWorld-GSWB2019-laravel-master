<?php

namespace App\Http\Requests;

class UsersRequest extends Request
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
        return [
            //'name'  => ['required', 'unique:users'],
            //'email' => ['required', 'email', 'unique:users'],
            'name'  => 'required|unique:users,id,'.$this->get('id'),
            'email' => 'required|unique:users,id,'.$this->get('id'),
            //'password' => ['required'],
        ];
    }
}
