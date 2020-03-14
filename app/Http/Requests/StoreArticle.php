<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreArticle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
          'title.required' => 'Введите название статьи',
          'title.sting' => 'Здесь должен быть текст',
          'title.max' => 'Название должно быть не больше 100 символов',

          'body.required' => 'Введите статью',
          'body.string' => 'Здесь должен быть текст',
        ];
    }
}
