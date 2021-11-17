<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetListBuyerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firebase_uid' => 'required|string',
            'product_id' => 'required',
        ];
    }
}
