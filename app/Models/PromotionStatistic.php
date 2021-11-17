<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PromotionStatistic
 *
 * @property int $id
 * @property int $promotion_id
 * @property string $statistic_date
 * @property int $display_count
 * @property int $reach_count
 * @property int $click_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PromotionStatistic newModelQuery()
 * @method static Builder|PromotionStatistic newQuery()
 * @method static Builder|PromotionStatistic query()
 * @method static Builder|PromotionStatistic whereClickCount($value)
 * @method static Builder|PromotionStatistic whereCreatedAt($value)
 * @method static Builder|PromotionStatistic whereDisplayCount($value)
 * @method static Builder|PromotionStatistic whereId($value)
 * @method static Builder|PromotionStatistic wherePromotionId($value)
 * @method static Builder|PromotionStatistic whereReachCount($value)
 * @method static Builder|PromotionStatistic whereStatisticDate($value)
 * @method static Builder|PromotionStatistic whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PromotionStatistic extends AbstractModel
{
    protected $table = 'promotion_statistic';

    protected $fillable = [
        'promotion_id',
        'statistic_date',
        'display_count',
        'reach_count',
        'click_count',
    ];
}
