<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoHourly
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $statistics_hour
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoHourly newModelQuery()
 * @method static Builder|StatisticsLocalinfoHourly newQuery()
 * @method static Builder|StatisticsLocalinfoHourly query()
 * @method static Builder|StatisticsLocalinfoHourly whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoHourly whereId($value)
 * @method static Builder|StatisticsLocalinfoHourly whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoHourly whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoHourly whereStatisticsHour($value)
 * @method static Builder|StatisticsLocalinfoHourly whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoHourly whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoHourly extends AbstractModel
{
    protected $table = 'statistics_localinfo_hourly';

    protected $fillable = [
        'statistics_date',
        'statistics_hour',
        'localinfo_id',
        'total_clicks',
    ];
}