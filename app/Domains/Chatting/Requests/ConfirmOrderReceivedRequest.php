<?php

namespace App\Domains\Chatting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmOrderReceivedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message_id' => 'required',
        ];
    }
}
