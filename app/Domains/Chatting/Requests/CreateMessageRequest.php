<?php

namespace App\Domains\Chatting\Requests;

use App\Enum\MessageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type'                  => ['required', Rule::in(MessageType::getValidTypes())],
            'text'                  => ['string', Rule::requiredIf($this->type === MessageType::TEXT)],
            'attachment'            => ['image', Rule::requiredIf($this->type === MessageType::IMAGE)],
            'location.x'            => [Rule::requiredIf($this->type === MessageType::LOCATION)],
            'location.y'            => [Rule::requiredIf($this->type === MessageType::LOCATION)],
            'location.address_name' => [Rule::requiredIf($this->type === MessageType::LOCATION)],
            'sticker'               => [Rule::requiredIf($this->type === MessageType::STICKER)],
            'shipping_address_id'   => [Rule::requiredIf($this->type === MessageType::SHIPPING_ADDRESS)],
            'bank_account_id'       => [Rule::requiredIf($this->type === MessageType::BANK_ACCOUNT)],
            'shipping_company.name' => [Rule::requiredIf($this->type === MessageType::SHIPPING_COMPANY)],
            'shipping_company.code' => [Rule::requiredIf($this->type === MessageType::SHIPPING_COMPANY)],
            'shipping_company.date' => [Rule::requiredIf($this->type === MessageType::SHIPPING_COMPANY)],
            'id'                    => 'required',
        ];
    }
}
