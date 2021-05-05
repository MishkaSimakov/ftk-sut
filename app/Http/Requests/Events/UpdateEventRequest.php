<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends StoreEventRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['image'] = 'nullable|image';

        return $rules;
    }
}
