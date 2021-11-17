<?php

namespace App\Domains\Chatting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreThreadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'store_id'     => 'required|numeric',
            'localinfo_id' => 'numeric',
        ];
    }
}
