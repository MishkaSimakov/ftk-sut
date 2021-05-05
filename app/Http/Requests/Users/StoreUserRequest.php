<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'register_token' => ['nullable', 'string', 'size:12'],
            'type' => ['required', 'in:teacher,pupil'],
        ];
    }
}
