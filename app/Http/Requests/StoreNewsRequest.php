<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100|string',
            'body' => 'required|max:5000|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите название новости',
            'title.max' => 'Название должно быть короче 100 символов',
            'title.string' => 'Здесь должен быть текст',

            'body.required' => 'Введите текст новости',
            'body.max' => 'Текст должно быть короче 5000 символов',
            'body.string' => 'Здесь должен быть текст',
        ];
    }
}
