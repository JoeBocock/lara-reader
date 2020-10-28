<?php

namespace App\Http\Requests;

use App\Rules\RSSFeed;
use Illuminate\Foundation\Http\FormRequest;

class StoreFeedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required', 'url', 'unique:feeds,origin', new RSSFeed()],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'url.unique' => 'You\'re already subscribed to that feed.',
        ];
    }
}
