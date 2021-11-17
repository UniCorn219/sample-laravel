<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class AmountType extends Enum
{
    public const WON        = 1; // default type is South Korean won (KRW or ₩) => amount_rate = 1
    public const FTSY_TOKEN = 2;
}
