<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoAge
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $age_range
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoAge newModelQuery()
 * @method static Builder|StatisticsLocalinfoAge newQuery()
 * @method static Builder|StatisticsLocalinfoAge query()
 * @method static Builder|StatisticsLocalinfoAge whereAgeRange($value)
 * @method static Builder|StatisticsLocalinfoAge whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoAge whereId($value)
 * @method static Builder|StatisticsLocalinfoAge whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoAge whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoAge whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoAge whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoAge extends AbstractModel
{
    protected $table = 'statistics_localinfo_age';

    protected $fillable = [
        'statistics_date',
        'age_range',
        'total_posts',
        'total_clicks',
    ];
}
