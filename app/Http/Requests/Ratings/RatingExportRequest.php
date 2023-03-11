<?php

namespace App\Http\Requests\Ratings;

use Illuminate\Foundation\Http\FormRequest;

class RatingExportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start'
        ];
    }
}
