<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StoreAddress
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $area_id
 * @property int localpost_id
 * @property int $total_clicks
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserAddress newModelQuery()
 * @method static Builder|UserAddress newQuery()
 * @method static Builder|UserAddress query()
 * @method static Builder|UserAddress whereAreaId($value)
 * @method static Builder|UserAddress whereCreatedAt($value)
 * @method static Builder|UserAddress whereDeletedAt($value)
 * @method static Builder|UserAddress whereDistrictId($value)
 * @method static Builder|UserAddress whereId($value)
 * @method static Builder|UserAddress whereLocation($value)
 * @method static Builder|UserAddress whereProvinceId($value)
 * @method static Builder|UserAddress whereUpdatedAt($value)
 * @method static Builder|UserAddress whereUserId($value)
 * @mixin Eloquent
 */

class StatisticsLocalPostLocation extends Model
{
    protected $table = 'statistics_localpost_location';

    protected $fillable = [
        'statistics_date',
        'area_id',
        'localpost_id',
        'total_clicks'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
