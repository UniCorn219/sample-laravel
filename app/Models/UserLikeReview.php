<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserLikeReview
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_reviewable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview newQuery()
 * @method static Builder|UserLikeReview onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLikeReview whereUserReviewableId($value)
 * @method static Builder|UserLikeReview withTrashed()
 * @method static Builder|UserLikeReview withoutTrashed()
 * @mixin Eloquent
 */
class UserLikeReview extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'user_like_reviews';

    protected $fillable = [
        'user_id',
        'user_reviewable_id',
    ];
}
