<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class ProductStatus extends Enum
{
    public const SELLING  = 1;
    public const RESERVED = 2;
    public const SOLD     = 3; // sold and not have review user
    public const COMPLETE = 4; // sold and has review user
    public const REJECTED = 5;
    public const HIDDEN   = 6;
    public const ORDERING = 7; // not selling or sold, just waiting shipping
}
