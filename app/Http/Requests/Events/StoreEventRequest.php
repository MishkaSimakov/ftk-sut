<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'name' => 'required|string|max:75',
            'description' => 'nullable|string|max:200',

            'date_start' => 'required|date|after:now',
            'date_end' => 'required|date|after:date_start',

            'image' => 'required|image',

            'is_travel' => 'nullable|in:on,off',
            'travel_type' => 'required_if:is_travel,on',
            'travel_distance' => 'required_if:is_travel,on|min:0|numeric'
        ];
    }
}
