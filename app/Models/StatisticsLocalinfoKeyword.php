<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoKeyword
 *
 * @property int $id
 * @property string $statistics_date
 * @property string $keyword
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoKeyword newModelQuery()
 * @method static Builder|StatisticsLocalinfoKeyword newQuery()
 * @method static Builder|StatisticsLocalinfoKeyword query()
 * @method static Builder|StatisticsLocalinfoKeyword whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereId($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereKeyword($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoKeyword whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoKeyword extends AbstractModel
{
    protected $table = 'statistics_localinfo_keyword';

    protected $fillable = [
        'statistics_date',
        'keyword',
        'localinfo_id',
        'total_clicks',
    ];
}
