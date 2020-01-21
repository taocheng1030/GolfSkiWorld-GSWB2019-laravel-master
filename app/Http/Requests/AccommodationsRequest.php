<?php

namespace App\Http\Requests;

class AccommodationsRequest extends Request
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
            'site_id'     => ['required', 'numeric'],
            'type_id'     => ['required', 'numeric'],
            'name'        => ['required'],
            // 'description' => ['required'],
            // 'owner'       => ['required'],
            'latitude'    => ['required'],
            'longitude'   => ['required'],
            'country_id'  => ['required', 'numeric'],
            // 'state_id'    => ['required', 'numeric'],
            // 'city_id'     => ['required', 'numeric'],
            'state_id'    => ['numeric'],
            'city_id'     => ['numeric'],
            // 'street'      => ['required'],
            // 'zip'         => ['required'],
            // 'phone'       => ['required'],
            // 'email'       => ['required', 'email'],
            // 'link'        => ['required'],
            'email'       => ['email'],
            'thumbnail_url' => ['url'],
            'thumbnail'     => ['file', 'max:'.config('photo.max_size'), 'mimetypes:'.config('photo.mimeTypes')],
        ];
    }
}
