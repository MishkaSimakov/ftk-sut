<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:75'],
            'body' => ['required', 'string'],
            'tags' => ['nullable', 'string'],

            'delayed_publication' => ['string', 'in:on,off'],
            'date' => ['nullable', 'date'],
            'author' => [
                Rule::requiredIf(auth()->user()->is_admin),
                'exists:users,id'
            ]
        ];
    }
}
