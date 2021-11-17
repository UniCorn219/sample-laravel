<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class PromotionPriceRange extends Enum
{
    public const RANGE_1K_10K            = 1;
    public const RANGE_10K_50K           = 2;
    public const RANGE_50K_500K          = 3;
    public const RANGE_GREATER_THAN_500K = 4;

    protected static array $ranges = [
        self::RANGE_1K_10K            => [1000, 10000],
        self::RANGE_10K_50K           => [10001, 50000],
        self::RANGE_50K_500K          => [50001, 500000],
        self::RANGE_GREATER_THAN_500K => [500001, null],
    ];

    public static function getPriceRange(int $price): int
    {
        foreach (self::$ranges as $key => $range) {
            if ($price >= $range[0] && $price <= $range[1]) {
                return $key;
            }

            if (is_null($range[1])) {
                return self::RANGE_GREATER_THAN_500K;
            }
        }

        return 0;
    }
}
