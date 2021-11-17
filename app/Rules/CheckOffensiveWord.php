<?php

namespace App\Rules;

use App\Domains\User\Jobs\UserBatteryPointJob;
use App\Enum\UserActionableType;
use App\Models\OffensiveWord;
use Illuminate\Contracts\Validation\Rule;

class CheckOffensiveWord implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $count = OffensiveWord::whereRaw("strpos(?, word) > 0", [strtolower($value)])->count();

        if ($count > 0) {
            $param = ['userId' => auth()->id(), 'type' => UserActionableType::OFFENSIVE_WORD];
            app(UserBatteryPointJob::class, $param)->handle();
        }

        return $count === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('messages.product_not_create_because_of_offensive');
    }
}
