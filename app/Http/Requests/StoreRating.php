<?php

namespace App\Http\Requests;

use App\Rules\UniqueDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRating extends FormRequest
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
            'date' => [
                'required',
                'date',
                new UniqueDate(),
            ],
            'file' => 'required|mimes:xls',
            'type' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
          'date.required' => 'Не хватает даты',
          'date.date' => 'Здесь должна быть дата',

          'file.required' => 'Не хватает файла',
          'file.mimes' => 'Рейтинг должен быть таблицей Excel',

          'type.required' => 'Выберите один из типов рейтинга',
        ];
    }
}
