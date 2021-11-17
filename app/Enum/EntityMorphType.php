<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class EntityMorphType extends Enum
{
    const PRODUCT                  = 1;
    const STORE                    = 2;
    const USER                     = 3;
    const LOCAL_POST               = 4;
    const LOCAL_INFO               = 5;
    const LOCAL_POST_COMMENT       = 6;
    const LOCAL_INFO_COMMENT       = 7;
    const LOCAL_INFO_LIKE          = 8;
    const LOCAL_POST_LIKE          = 9;
    const PRODUCT_LIKE             = 10;
    const PRODUCT_TOP              = 11;
    const USER_ACTION              = 12;
    const USER_REVIEWABLE          = 13;
    const USER_REVIEW              = 14;
    const MISSION                  = 15;
    const INTRODUCE_MEMBER_HISTORY = 16;
}
