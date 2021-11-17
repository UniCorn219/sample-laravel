<?php


namespace App\Enum;

use BenSampo\Enum\Enum;

final class UserReviewableType extends Enum
{
    const STORE = 1;
    const TRANSACTION = 2;
    const USER = 3;
}
