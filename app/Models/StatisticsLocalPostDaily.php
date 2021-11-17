<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalPostDaily
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $localpost_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionDaily newModelQuery()
 * @method static Builder|StatisticsPromotionDaily newQuery()
 * @method static Builder|StatisticsPromotionDaily query()
 * @method static Builder|StatisticsPromotionDaily whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionDaily whereId($value)
 * @method static Builder|StatisticsPromotionDaily whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionDaily whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionDaily whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionDaily whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalPostDaily extends AbstractModel
{
    protected $table = 'statistics_localpost_daily';

    protected $fillable = [
        'statistics_date',
        'localpost_id',
        'total_clicks',
    ];
}
