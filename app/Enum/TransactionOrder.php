<?php

namespace App\Enum;

use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

class TransactionOrder extends Enum
{
    public const PRODUCT   = 'PROD';
    public const BANK      = 'BANK';
    public const PROMOTION = 'PROMO';

    public static function generate($type): string
    {
        $type = Str::upper($type);
        $uuid = Str::upper(Str::replace('-', '', Str::uuid()));

        if (!self::hasValue($type)) {
            $type = self::PRODUCT;
        }

        return $type . $uuid;
    }
}
