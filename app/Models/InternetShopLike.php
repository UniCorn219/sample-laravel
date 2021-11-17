<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class InternetShopLike
 * @package App\Models
 * @method static where(string $string, mixed $userId)
 */

class InternetShopLike extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'internet_shop_likes';

    protected $fillable = [
        'id',
        'user_id',
        'internet_shop_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function internetShop(): BelongsTo
    {
        return $this->belongsTo(InternetShop::class, 'internet_shop_id');
    }
}
