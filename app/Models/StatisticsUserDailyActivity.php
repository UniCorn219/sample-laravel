<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserDailyActivity
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $user_id
 * @property int $total_activities
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserDailyActivity newModelQuery()
 * @method static Builder|StatisticsUserDailyActivity newQuery()
 * @method static Builder|StatisticsUserDailyActivity query()
 * @method static Builder|StatisticsUserDailyActivity whereCreatedAt($value)
 * @method static Builder|StatisticsUserDailyActivity whereId($value)
 * @method static Builder|StatisticsUserDailyActivity whereStatisticsDate($value)
 * @method static Builder|StatisticsUserDailyActivity whereTotalActivities($value)
 * @method static Builder|StatisticsUserDailyActivity whereUpdatedAt($value)
 * @method static Builder|StatisticsUserDailyActivity whereUserId($value)
 * @mixin Eloquent
 */
class StatisticsUserDailyActivity extends AbstractModel
{
    protected $table = 'statistics_user_daily_activities';

    protected $fillable = [
        'statistics_date',
        'user_id',
        'total_activities',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
