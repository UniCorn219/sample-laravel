<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePhraseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phrase' => 'required|string'
        ];
    }
}
