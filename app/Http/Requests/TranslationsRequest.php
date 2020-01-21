<?php

namespace App\Http\Requests;

class TranslationsRequest extends Request
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
            'language_id' => ['required', 'numeric'],
            'key'         => ['required', 'string'],
            'translate'   => ['required', 'string'],
        ];
    }
}
