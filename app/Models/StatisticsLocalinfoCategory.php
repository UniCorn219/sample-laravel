<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoCategory
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $category_id
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @method static Builder|StatisticsLocalinfoCategory newModelQuery()
 * @method static Builder|StatisticsLocalinfoCategory newQuery()
 * @method static Builder|StatisticsLocalinfoCategory query()
 * @method static Builder|StatisticsLocalinfoCategory whereCategoryId($value)
 * @method static Builder|StatisticsLocalinfoCategory whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoCategory whereId($value)
 * @method static Builder|StatisticsLocalinfoCategory whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoCategory whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoCategory whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoCategory extends AbstractModel
{
    protected $table = 'statistics_localinfo_category';

    protected $fillable = [
        'statistics_date',
        'category_id',
        'localinfo_id',
        'total_clicks',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
