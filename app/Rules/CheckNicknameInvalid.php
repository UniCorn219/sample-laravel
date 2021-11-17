<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckNicknameInvalid implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !str_contains($value, '떴다마켔') && !str_contains($value, '떴다마켓') && !str_contains(strtolower($value), 'ttutamarket');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.nickname_invalid');
    }
}
