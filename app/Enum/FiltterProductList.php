<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class FiltterProductList extends Enum
{

    public const SORT_BY = [
        'distance',//sort by distance for product
        'created_at',//sort by date create product
        'price',//sort by product price
        'location'//sort by location for product
    ];

    public const SORT_TYPE = [
        'desc',
        'asc'
    ];
}
