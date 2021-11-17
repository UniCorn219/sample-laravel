<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \App\Models\InternetShopReview
 *
 * @property int $id
 * @property int $internet_shop_id
 * @property int $user_id
 * @property int $star_number
 * @property string $content
 * @method static Builder|InternetShopReview newModelQuery()
 * @method static Builder|InternetShopReview newQuery()
 * @method static Builder|InternetShopReview query()
 * @mixin Eloquent
 */

class InternetShopReview extends AbstractModel
{

    use SoftDeletes;

    protected $table = 'internet_shop_reviews';

    protected $fillable = [
        'internet_shop_id',
        'user_id',
        'star_number',
        'content'
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
