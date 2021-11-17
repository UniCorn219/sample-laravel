<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserReportReview
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_reviewable_id
 * @property string|null $reason
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview newQuery()
 * @method static Builder|UserReportReview onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportReview whereUserTargetId($value)
 * @method static Builder|UserReportReview withTrashed()
 * @method static Builder|UserReportReview withoutTrashed()
 * @mixin Eloquent
 */
class UserReportReview extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'user_report_reviews';

    protected $fillable = [
        'user_id',
        'user_reviewable_id',
        'reason',
    ];
}
