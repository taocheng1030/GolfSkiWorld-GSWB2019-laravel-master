<?php

namespace App\Http\Requests;

class ArticlesRequest extends Request
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
            'language_id' => ['required', 'numeric'],
            'name'        => ['required'],
            'summary'     => ['required'],
            'author'      => ['required'],
            'publish_at'  => ['required'],
            'body'        => ['required'],
            'tags'        => ['required'],
        ];
    }
}
