<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:75',
            'description' => 'nullable|string|max:200',

            'date_start' => 'nullable|date|after:now',
            'date_end' => 'nullable|date|after:date_start',

            'image' => 'nullable|image',

            'is_travel' => 'nullable|in:on,off',
            'travel_type' => 'nullable|required_if:is_travel,on',
            'travel_distance' => 'nullable|required_if:is_travel,on|min:0|numeric'
        ];
    }
}
