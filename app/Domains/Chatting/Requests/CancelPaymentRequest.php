<?php

namespace App\Domains\Chatting\Requests;

use App\Enum\CancelPaymentReason;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancelPaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'  => ['required', Rule::in(CancelPaymentReason::getValidTypes())],
            'other' => [Rule::requiredIf($this->type === CancelPaymentReason::OTHER)]
        ];
    }
}
