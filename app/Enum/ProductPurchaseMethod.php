<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class ProductPurchaseMethod extends Enum
{
    public const ONLINE  = 1;
    public const OFFLINE = 2;
    public const BOTH    = 3;
}
