<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\SellerReview
 *
 * @property int $id
 * @property int $seller_id
 * @property int $buyer_id
 * @property int $value
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SellerReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerReview newQuery()
 * @method static Builder|SellerReview withTrashed()
 * @method static Builder|SellerReview withoutTrashed()
 * @mixin Eloquent
 */
class UserReview extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'user_reviews';

    const NOT_GOOD = 1;
    const STANDARD = 2;
    const GOOD = 3;
    const PERFECT = 4;

    protected $fillable = [
        'reviewer_id',
        'receiver_id',
        'product_id',
        'value'
    ];
}