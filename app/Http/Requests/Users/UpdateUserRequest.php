<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user()->id),
                'email',
            ]
        ];
    }
}
