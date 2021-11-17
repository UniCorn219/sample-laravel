<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalPostAge
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $age_range
 * @property int $localpost_id
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

class StatisticsLocalPostAge extends Model
{
    protected $table = 'statistics_localpost_age';

    protected $fillable = [
        'statistics_date',
        'age_range',
        'localpost_id',
        'total_clicks'
    ];
}
