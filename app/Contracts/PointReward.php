<?php

namespace App\Contracts;


/**
 * Class PointReward
 * @package App\Contracts
 */
abstract class PointReward
{
    const FORCE_BLACKLIST_CHECK = true;

    const TYPE_1 = 1;

    const SHOPPING_MALL_DOMAIN = 'https://ttuttamarket.shop';

    const SHOPPING_MALL_PROCESS_LOGIN_URL = 'https://ttuttamarket.shop/login_process/changepoint';
}
