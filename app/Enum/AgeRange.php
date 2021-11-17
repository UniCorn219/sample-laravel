<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class AgeRange extends Enum
{
    public const RANGE_10_19                    = 1;
    public const RANGE_20_29                    = 2;
    public const RANGE_30_39                    = 3;
    public const RANGE_40_49                    = 4;
    public const RANGE_50_59                    = 5;
    public const RANGE_GREATER_THAN_EQUAL_TO_60 = 6;

    protected static array $ranges = [
        self::RANGE_10_19                    => [10, 19],
        self::RANGE_20_29                    => [20, 29],
        self::RANGE_30_39                    => [30, 39],
        self::RANGE_40_49                    => [40, 49],
        self::RANGE_50_59                    => [50, 59],
        self::RANGE_GREATER_THAN_EQUAL_TO_60 => [60, null],
    ];

    public static function getAgeRange(int $age): int
    {
        foreach (self::$ranges as $key => $range) {
            if ($age >= $range[0] && $age <= $range[1]) {
                return $key;
            }

            if (is_null($range[1])) {
                return self::RANGE_GREATER_THAN_EQUAL_TO_60;
            }
        }

        return 0;
    }
}
