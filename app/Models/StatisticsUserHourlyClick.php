<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserHourlyClick
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $statistics_hour
 * @property int $user_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserHourlyClick newModelQuery()
 * @method static Builder|StatisticsUserHourlyClick newQuery()
 * @method static Builder|StatisticsUserHourlyClick query()
 * @method static Builder|StatisticsUserHourlyClick whereCreatedAt($value)
 * @method static Builder|StatisticsUserHourlyClick whereId($value)
 * @method static Builder|StatisticsUserHourlyClick whereStatisticsDate($value)
 * @method static Builder|StatisticsUserHourlyClick whereStatisticsHour($value)
 * @method static Builder|StatisticsUserHourlyClick whereTotalClicks($value)
 * @method static Builder|StatisticsUserHourlyClick whereUpdatedAt($value)
 * @method static Builder|StatisticsUserHourlyClick whereUserId($value)
 * @mixin Eloquent
 */
class StatisticsUserHourlyClick extends AbstractModel
{
    protected $table = 'statistics_user_hourly_click';

    protected $fillable = [
        'statistics_date',
        'statistics_hour',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
