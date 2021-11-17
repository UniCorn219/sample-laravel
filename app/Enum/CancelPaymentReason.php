<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class CancelPaymentReason extends Enum
{
    const WAITING_TIME_TOO_LONG     = 'waiting_time_too_long';
    const CHANGE_INFO_RECEIVE_ORDER = 'change_info_receive_order';
    const BETTER_PRICE              = 'better_price';
    const OTHER                     = 'other';

    /**
     * Get valid reason types.
     *
     * @return array
     */
    public static function getValidTypes(): array
    {
        return [
            self::WAITING_TIME_TOO_LONG,
            self::CHANGE_INFO_RECEIVE_ORDER,
            self::BETTER_PRICE,
            self::OTHER,
        ];
    }
}
