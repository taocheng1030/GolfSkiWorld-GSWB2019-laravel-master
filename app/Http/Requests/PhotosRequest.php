<?php

namespace App\Http\Requests;

class PhotosRequest extends Request
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
            'id'      => ['required', 'numeric'],
            'model'   => ['sometimes', 'required', 'string', 'in:users,deals,lastminutes,resorts,restaurants,accommodations,awardinfos,abouts,destinfos,articles'],
            'files.*' => ['sometimes', 'required', 'file', 'max:'.config('photo.max_size'), 'mimetypes:'.config('photo.mimeTypes')],
        ];
    }

    public function messages()
    {
        return [
            'files.*.mimetypes' => 'Incorrect file type'
        ];
    }
}
