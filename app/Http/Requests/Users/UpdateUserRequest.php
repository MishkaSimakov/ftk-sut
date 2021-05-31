<?php

namespace App\Http\Requests\Users;

use App\Enums\UserType;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        $is_admin = auth()->check() and auth()->user()->is_admin;

        return [
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->route('user')->id),
                'email',
            ],
            'name' => [Rule::requiredIf($is_admin), 'string'],
            'type' => [Rule::requiredIf($is_admin), new EnumValue(UserType::class, false)],
            'is_admin' => ['nullable', 'in:on,off']
        ];
    }
}
