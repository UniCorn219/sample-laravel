<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteKeywordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_remove_all' => 'boolean',
            'keyword_id'    => 'required_without:is_remove_all'
        ];
    }
}
