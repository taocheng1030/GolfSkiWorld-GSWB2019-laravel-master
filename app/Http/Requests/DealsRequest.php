<?php

namespace App\Http\Requests;

class DealsRequest extends Request
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
            'site_id'           => ['required', 'numeric'],
            'limiter_id'        => ['required'],
            'name'              => ['required'],
            // 'shortdescription'  => ['required'],
            // 'description'       => ['required'],
            'latitude'          => ['required'],
            'longitude'         => ['required'],
            // 'originalprice'     => ['required'],
            'price'             => ['required'],
            'currency'          => ['required'],
            // 'link'              => ['required', 'url'],
            // 'owner'             => ['required'],
            // 'owner_email'       => ['required', 'email'],
            // 'owner_phone'       => ['required'],
            'link'              => ['url'],
            'owner_email'       => ['email'],
            'starts'            => $this->requireLimiter(1, ['before:ends', 'date_format:Y-m-d H:i:s']),
            'ends'              => $this->requireLimiter(1, ['after:starts', 'date_format:Y-m-d H:i:s']),
            'numberofpurchases' => $this->requireLimiter(2, ['numeric']),
            'thumbnail_url'     => ['url'],
            'thumbnail'         => ['file', 'max:'.config('photo.max_size'), 'mimetypes:'.config('photo.mimeTypes')],
            'movie_url'         => ['url'],
            'movie'             => ['file', 'max:'.config('video.max_size'), 'mimetypes:'.config('video.mimeTypes'), 'duration:'.config('video.max_duration')],
        ];
    }

    public function messages()
    {
        return [
            'duration' => 'Video duration must not exceed ' . config('video.max_duration') . ' seconds',
            'mimetypes' => 'Incorrect file type'
        ];
    }

    private function requireLimiter($value, $rules)
    {
        return ($this->get('limiter_id') == $value) ? array_merge(['required'], $rules) : $rules;
    }
}
