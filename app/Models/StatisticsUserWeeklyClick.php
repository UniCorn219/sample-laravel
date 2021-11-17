<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserWeeklyClick
 *
 * @property int $id
 * @property int $year_week
 * @property int $user_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserWeeklyClick newModelQuery()
 * @method static Builder|StatisticsUserWeeklyClick newQuery()
 * @method static Builder|StatisticsUserWeeklyClick query()
 * @method static Builder|StatisticsUserWeeklyClick whereCreatedAt($value)
 * @method static Builder|StatisticsUserWeeklyClick whereId($value)
 * @method static Builder|StatisticsUserWeeklyClick whereTotalClicks($value)
 * @method static Builder|StatisticsUserWeeklyClick whereUpdatedAt($value)
 * @method static Builder|StatisticsUserWeeklyClick whereUserId($value)
 * @method static Builder|StatisticsUserWeeklyClick whereYearWeek($value)
 * @mixin Eloquent
 */
class StatisticsUserWeeklyClick extends AbstractModel
{
    protected $table = 'statistics_user_weekly_click';

    protected $fillable = [
        'year_week',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
