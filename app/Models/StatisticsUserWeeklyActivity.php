<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserWeeklyActivity
 *
 * @property int $id
 * @property int $year_week
 * @property int $user_id
 * @property int $total_activities
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserWeeklyActivity newModelQuery()
 * @method static Builder|StatisticsUserWeeklyActivity newQuery()
 * @method static Builder|StatisticsUserWeeklyActivity query()
 * @method static Builder|StatisticsUserWeeklyActivity whereCreatedAt($value)
 * @method static Builder|StatisticsUserWeeklyActivity whereId($value)
 * @method static Builder|StatisticsUserWeeklyActivity whereTotalActivities($value)
 * @method static Builder|StatisticsUserWeeklyActivity whereUpdatedAt($value)
 * @method static Builder|StatisticsUserWeeklyActivity whereUserId($value)
 * @method static Builder|StatisticsUserWeeklyActivity whereYearWeek($value)
 * @mixin Eloquent
 */
class StatisticsUserWeeklyActivity extends AbstractModel
{
    protected $table = 'statistics_user_weekly_activities';

    protected $fillable = [
        'year_week',
        'user_id',
        'total_activities',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
