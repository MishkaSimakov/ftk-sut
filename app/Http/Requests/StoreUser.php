<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id)
            ],
            'birthday' => 'nullable|date',
            'description' => 'nullable|string|max:500',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'vk_link' => 'nullable|string|active_url'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Это обязательное поле',
            'email.email' => 'Здесь должен быть email',
            'email.unique' => 'Кто-то уже зарегистрирован с таким email',

            'birthday.date' => 'Здесь должна быть дата',

            'description.string' => 'Здесь должен быть текст',
            'description.max' => 'Максимальная длина 500 символов',

            'phone.regex' => 'Здесь должен быть телефон',

            'vk_link.string' => 'Здесь должна быть строка',
            'vk_link.active_url' => 'Эта ссылка недействительна',
        ];
    }
}
