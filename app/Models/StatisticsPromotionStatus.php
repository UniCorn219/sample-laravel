<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionStatus
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $status
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionStatus newModelQuery()
 * @method static Builder|StatisticsPromotionStatus newQuery()
 * @method static Builder|StatisticsPromotionStatus query()
 * @method static Builder|StatisticsPromotionStatus whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionStatus whereId($value)
 * @method static Builder|StatisticsPromotionStatus whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionStatus whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionStatus whereStatus($value)
 * @method static Builder|StatisticsPromotionStatus whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionStatus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionStatus extends AbstractModel
{
    protected $table = 'statistics_promotion_status';

    protected $fillable = [
        'statistics_date',
        'status',
        'localinfo_id',
        'total_clicks',
    ];
}
