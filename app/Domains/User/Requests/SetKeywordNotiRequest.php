<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetKeywordNotiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'required|string'
        ];
    }
}
