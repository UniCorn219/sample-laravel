<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserLocation
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $area_id
 * @property int $user_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Area|null $area
 * @method static Builder|StatisticsUserLocation newModelQuery()
 * @method static Builder|StatisticsUserLocation newQuery()
 * @method static Builder|StatisticsUserLocation query()
 * @method static Builder|StatisticsUserLocation whereAreaId($value)
 * @method static Builder|StatisticsUserLocation whereCreatedAt($value)
 * @method static Builder|StatisticsUserLocation whereId($value)
 * @method static Builder|StatisticsUserLocation whereStatisticsDate($value)
 * @method static Builder|StatisticsUserLocation whereTotalClicks($value)
 * @method static Builder|StatisticsUserLocation whereTotalUsers($value)
 * @method static Builder|StatisticsUserLocation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsUserLocation extends AbstractModel
{
    protected $table = 'statistics_user_locations';

    protected $fillable = [
        'statistics_date',
        'area_id',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasOne
     */
    public function area(): HasOne
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }
}
