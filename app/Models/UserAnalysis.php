<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserAnalysis
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_comment
 * @property int $total_local_post
 * @property int $total_report
 * @property int $total_following
 * @property int $total_follower
 * @property int $total_product
 * @property int $total_review_transaction
 * @property int $total_purchase_new_phones
 * @property int $total_purchase_old_phones
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserAnalysis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalFollower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalFollowing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalPurchaseNewPhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalPurchaseOldPhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalReviewTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserAnalysis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserAnalysis withoutTrashed()
 * @mixin \Eloquent
 * @property int $total_review_seller
 * @property bool $battery_up_to_level_5_within_100_day
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereBatteryUpToLevel5Within100Day($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalLocalPost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAnalysis whereTotalReviewSeller($value)
 */
class UserAnalysis extends AbstractModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_analysis';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'total_comment',
        'total_local_post',
        'total_product',
        'total_report',
        'total_following',
        'total_follower',
        'total_review_transaction',
        'total_purchase_new_phones',
        'total_purchase_old_phones',
    ];
}
