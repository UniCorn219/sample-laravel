<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopKeyword extends Model
{
    protected $table = 'top_keyword';

    const MAX_TOP_KEYWORD = 8;

    protected $fillable = [
        'keyword',
        'quantity',
        'is_top_day',
        'is_top_week',
        'is_top_month',
        'type'
    ];
}
