<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserAges
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $age_range
 * @property int $user_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $age_range_text
 * @method static Builder|StatisticsUserAges newModelQuery()
 * @method static Builder|StatisticsUserAges newQuery()
 * @method static Builder|StatisticsUserAges query()
 * @method static Builder|StatisticsUserAges whereAgeRange($value)
 * @method static Builder|StatisticsUserAges whereCreatedAt($value)
 * @method static Builder|StatisticsUserAges whereId($value)
 * @method static Builder|StatisticsUserAges whereStatisticsDate($value)
 * @method static Builder|StatisticsUserAges whereTotalClicks($value)
 * @method static Builder|StatisticsUserAges whereTotalUsers($value)
 * @method static Builder|StatisticsUserAges whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsUserAges extends AbstractModel
{
    protected $table = 'statistics_user_ages';

    protected $attributes = [
        'statistics_date',
        'age_range',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'age_range_text',
    ];

    public function getAgeRangeTextAttribute()
    {
        $value = $this->attributes['age_range'];

        return Arr::get(config('constant.age_range'), $value, '');
    }
}
