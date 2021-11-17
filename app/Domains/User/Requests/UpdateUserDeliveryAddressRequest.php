<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDeliveryAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'recipient_name'  => 'required|string',
            'recipient_phone' => 'required|numeric',
            'is_default'      => 'required|boolean',
            'post_code'       => 'required|numeric',
            'address'         => 'required|string',
            'address_detail'  => 'nullable|string',
            'note'            => 'nullable|string'
        ];
    }
}
