<?php

namespace App\Domains\Chatting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayCoinRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_id'    => 'required|integer',
            'thread_fuid'  => 'required|string',
            'token_number' => 'required|integer',
        ];
    }
}
