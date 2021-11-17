<?php

namespace App\Domains\Chatting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
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
            'time_remind'      => 'required|date_format:Y-m-d\TH:i:s.vP|before:time_reservation',
            'time_reservation' => 'required|date_format:Y-m-d\TH:i:s.vP|after:time_remind'
        ];
    }
}
