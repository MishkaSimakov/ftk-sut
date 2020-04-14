<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSchedule extends FormRequest
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
            'subtitle' => 'max:100|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'file' => 'required|file|image'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите название мероприятия',
            'title.max' => 'Название должно быть короче 100 символов',
            'title.string' => 'Здесь должен быть текст',

            'subtitle.max' => 'Подзаголовок должно быть короче 100 символов',
            'subtitle.string' => 'Здесь должен быть текст',

            'date_start.required' => 'Мероприятие должно когда-нибудь начаться',
            'date_start.date' => 'Здесь должна быть дата',
            'date_start.after' => 'Мероприятие должно начинаться не сейчас и не в прошлом',

            'date_end.required' => 'Мероприятие должно когда-нибудь закончиться',
            'date_end.date' => 'Здесь должна быть дата',
            'date_end.after' => 'Мероприятие должно закончиться позже, чем начаться',

            'file.required' => 'Необходимо загрузить фотографию',
            'file.file' => 'Здесь должен быть файл',
            'file.image' => 'Здесь должно быть изображение',
        ];
    }
}
