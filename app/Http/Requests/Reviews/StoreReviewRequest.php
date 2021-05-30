<?php

namespace App\Http\Requests\Reviews;

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
