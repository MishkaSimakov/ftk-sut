<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' => 'required|max:75',
            'body' => 'required',
            'date' => 'required|date',
            'notify_users' => 'nullable|in:on,off'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => config('errors.validation.required'),
            'title.max' => sprintf(config('errors.validation.max'), 75),

            'body.required' => config('errors.validation.required'),

            'date.required' => config('errors.validation.required'),
            'date.date' => config('errors.validation.date'),
        ];
    }
}
