<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PointSetting
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PointSetting newModelQuery()
 * @method static Builder|PointSetting newQuery()
 * @method static Builder|PointSetting query()
 * @method static Builder|PointSetting whereCategoryId($value)
 * @method static Builder|PointSetting whereCreatedAt($value)
 * @method static Builder|PointSetting whereId($value)
 * @method static Builder|PointSetting whereUpdatedAt($value)
 * @method static Builder|PointSetting whereUserId($value)
 * @mixin Eloquent
 */
class PointSetting extends AbstractModel
{
    protected $table = 'point_settings';

    protected $fillable = [
        'introduce_member',
        'introduce_member_bonus'
    ];
}
