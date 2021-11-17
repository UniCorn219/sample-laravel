<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

class TransactionAmountRange extends Enum
{
    public const RANGE_0_1K            = 1;
    public const RANGE_1K_10K          = 2;
    public const RANGE_10K_50K         = 3;
    public const RANGE_50K_100K        = 4;
    public const RANGE_100K_1M         = 5;
    public const RANGE_GREATER_THAN_1M = 6;

    protected static array $ranges = [
        self::RANGE_0_1K            => [0, 1000],
        self::RANGE_1K_10K          => [1_001, 10_000],
        self::RANGE_10K_50K         => [10_001, 50_000],
        self::RANGE_50K_100K        => [50_001, 100_000],
        self::RANGE_100K_1M         => [100_001, 1_000_000],
        self::RANGE_GREATER_THAN_1M => [1_000_001, null],
    ];

    public static function getAmountRange(int $amount): int
    {
        foreach (self::$ranges as $key => $range) {
            if ($amount >= $range[0] && $amount <= $range[1]) {
                return $key;
            }

            if (is_null($range[1])) {
                return self::RANGE_GREATER_THAN_1M;
            }
        }

        return 0;
    }
}
