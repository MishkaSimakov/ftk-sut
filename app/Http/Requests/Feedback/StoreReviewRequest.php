<?php

namespace App\Http\Requests\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'body' => 'required',
        ];
    }
}
