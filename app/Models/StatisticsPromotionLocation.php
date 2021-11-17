<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionLocation
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $area_id
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Area $area
 * @method static Builder|StatisticsPromotionLocation newModelQuery()
 * @method static Builder|StatisticsPromotionLocation newQuery()
 * @method static Builder|StatisticsPromotionLocation query()
 * @method static Builder|StatisticsPromotionLocation whereAreaId($value)
 * @method static Builder|StatisticsPromotionLocation whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionLocation whereId($value)
 * @method static Builder|StatisticsPromotionLocation whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionLocation whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionLocation whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionLocation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionLocation extends AbstractModel
{
    protected $table = 'statistics_promotion_location';

    protected $fillable = [
        'statistics_date',
        'area_id',
        'localinfo_id',
        'total_clicks',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}