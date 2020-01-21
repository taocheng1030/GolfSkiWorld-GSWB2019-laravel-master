<?php

namespace App\Http\Requests;

class VideosRequest extends Request
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
            'model'   => ['sometimes', 'required', 'string', 'in:users,deals,lastminutes,resorts,restaurants,accommodations,sites'],
            'files.*' => ['sometimes', 'required', 'file', 'max:'.config('video.max_size'), 'mimetypes:'.config('video.mimeTypes'), 'duration:'.config('video.max_duration')],
        ];
    }

    public function messages()
    {
        return [
            'files.*.duration' => 'Video duration must not exceed '.config('video.max_duration').' seconds',
            'files.*.mimetypes' => 'Incorrect file type'
        ];
    }
}
