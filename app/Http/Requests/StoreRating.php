<?php

namespace App\Http\Requests;

use App\Rules\UniqueDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin; //TODO: добавить проверку на админа
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => [
                'required',
                'date',
                new UniqueDate(),
            ],
            'file' => 'required',
            'type' => 'required',
        ];
    }
}
