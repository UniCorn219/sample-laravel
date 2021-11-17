<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoWeekly
 *
 * @property int $id
 * @property int $year_week
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoWeekly newModelQuery()
 * @method static Builder|StatisticsLocalinfoWeekly newQuery()
 * @method static Builder|StatisticsLocalinfoWeekly query()
 * @method static Builder|StatisticsLocalinfoWeekly whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoWeekly whereId($value)
 * @method static Builder|StatisticsLocalinfoWeekly whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoWeekly whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoWeekly whereUpdatedAt($value)
 * @method static Builder|StatisticsLocalinfoWeekly whereYearWeek($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoWeekly extends AbstractModel
{
    protected $table = 'statistics_localinfo_weekly';

    protected $fillable = [
        'year_week',
        'localinfo_id',
        'total_clicks',
    ];
}