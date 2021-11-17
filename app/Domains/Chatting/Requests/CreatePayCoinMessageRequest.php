<?php

namespace App\Domains\Chatting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayCoinMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'buyer_id'     => ['required'],
            'seller_id'    => ['required'],
            'product_id'   => ['required'],
            'token_amount' => ['required'],
        ];
    }
}
