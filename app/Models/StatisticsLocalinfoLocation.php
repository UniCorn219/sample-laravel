<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoLocation
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $area_id
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Area $area
 * @method static Builder|StatisticsLocalinfoLocation newModelQuery()
 * @method static Builder|StatisticsLocalinfoLocation newQuery()
 * @method static Builder|StatisticsLocalinfoLocation query()
 * @method static Builder|StatisticsLocalinfoLocation whereAreaId($value)
 * @method static Builder|StatisticsLocalinfoLocation whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoLocation whereId($value)
 * @method static Builder|StatisticsLocalinfoLocation whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoLocation whereStatisticsDate($value)
 * @method static Builder|StatisticsLocalinfoLocation whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoLocation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoLocation extends AbstractModel
{
    protected $table = 'statistics_localinfo_location';

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