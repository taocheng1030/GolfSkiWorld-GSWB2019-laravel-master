<?php

namespace App\Http\Requests;

class AwardinfosRequest extends Request
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
            'name'          => ['required'],
            'left_title'    => ['required'],
            'left_info'     => ['required'],
            'middle_title'  => ['required'],
            'middle_info'   => ['required'],
            'right_title'   => ['required'],
            'right_info'    => ['required'],
            'thumbnail'     => ['file', 'max:' . config('photo.max_size'), 'mimetypes:' . config('photo.mimeTypes')],
        ];
    }
}
