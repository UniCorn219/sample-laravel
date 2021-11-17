<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserHourlyActivity
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $statistics_hour
 * @property int $user_id
 * @property int $total_activities
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserHourlyActivity newModelQuery()
 * @method static Builder|StatisticsUserHourlyActivity newQuery()
 * @method static Builder|StatisticsUserHourlyActivity query()
 * @method static Builder|StatisticsUserHourlyActivity whereCreatedAt($value)
 * @method static Builder|StatisticsUserHourlyActivity whereId($value)
 * @method static Builder|StatisticsUserHourlyActivity whereStatisticsDate($value)
 * @method static Builder|StatisticsUserHourlyActivity whereStatisticsHour($value)
 * @method static Builder|StatisticsUserHourlyActivity whereTotalActivities($value)
 * @method static Builder|StatisticsUserHourlyActivity whereUpdatedAt($value)
 * @method static Builder|StatisticsUserHourlyActivity whereUserId($value)
 * @mixin Eloquent
 */
class StatisticsUserHourlyActivity extends AbstractModel
{
    protected $table = 'statistics_user_hourly_activities';

    protected $fillable = [
        'statistics_date',
        'statistics_hour',
        'user_id',
        'total_activities',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
