<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionKeyword
 *
 * @property int $id
 * @property string $statistics_date
 * @property string $keyword
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionKeyword newModelQuery()
 * @method static Builder|StatisticsPromotionKeyword newQuery()
 * @method static Builder|StatisticsPromotionKeyword query()
 * @method static Builder|StatisticsPromotionKeyword whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionKeyword whereId($value)
 * @method static Builder|StatisticsPromotionKeyword whereKeyword($value)
 * @method static Builder|StatisticsPromotionKeyword whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionKeyword whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionKeyword whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionKeyword whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionKeyword extends AbstractModel
{
    protected $table = 'statistics_promotion_keyword';

    protected $fillable = [
        'statistics_date',
        'keyword',
        'localinfo_id',
        'total_clicks',
    ];
}