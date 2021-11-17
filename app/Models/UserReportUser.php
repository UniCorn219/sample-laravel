<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserReportUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_target_id
 * @property string|null $reason
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser newQuery()
 * @method static Builder|UserReportUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportUser whereUserTargetId($value)
 * @method static Builder|UserReportUser withTrashed()
 * @method static Builder|UserReportUser withoutTrashed()
 * @mixin Eloquent
 */
class UserReportUser extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'user_report_users';

    protected $fillable = [
        'user_id',
        'user_target_id',
        'reason',
    ];
}
