<?php

namespace App\Http\Requests;

class TvRequest extends Request
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
            'yID'  => ['string'],
            'ySearch'  => ['string'],
            'yChannel' => ['string'],
        ];
    }
}
