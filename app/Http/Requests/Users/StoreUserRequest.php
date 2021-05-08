<?php

namespace App\Http\Requests\Users;

use App\Enums\UserType;
use BenSampo\Enum\Rules\Enum;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'type' => ['required', new EnumValue(UserType::class, false)],
            'is_admin' => ['nullable', 'in:on,off']
        ];
    }
}
