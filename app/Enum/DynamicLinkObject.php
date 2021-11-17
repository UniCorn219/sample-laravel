<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class DynamicLinkObject extends Enum
{
    const LOCAL_POST    = 'localpost';
    const LOCAL_INFO    = 'localinfo';
    const PRODUCT       = 'product';
    const STORE         = 'store';
    const USER          = 'user';
    const INTERNET_SHOP = 'internet_shop';
}
