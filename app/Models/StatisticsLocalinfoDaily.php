<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoDaily
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoDaily newModelQuery()
 * @method static Builder|StatisticsLocalinfoDaily newQuery()
 * @method static Builder|StatisticsLocalinfoDaily query()
 * @method static Builder|StatisticsLocalinfoDaily whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoDaily whereId($value)
 * @method static Builder|StatisticsLocalinfoDaily whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoDaily whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoDaily whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoDaily whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoDaily extends AbstractModel
{
    protected $table = 'statistics_localinfo_daily';

    protected $fillable = [
        'statistics_date',
        'localinfo_id',
        'total_clicks',
    ];
}