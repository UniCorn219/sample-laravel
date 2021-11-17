<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordRanking extends Model
{
    protected $table = 'keyword_ranking';

    protected $fillable = [
        'type',
        'keyword',
        'quantity',
    ];
}
