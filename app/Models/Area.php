<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Area
 *
 * @property int $id
 * @property int $original_area_id
 * @property int $original_parent_area_id
 * @property int $level
 * @property string $name
 * @property int $total_user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Area newModelQuery()
 * @method static Builder|Area newQuery()
 * @method static Builder|Area query()
 * @method static Builder|Area whereCreatedAt($value)
 * @method static Builder|Area whereId($value)
 * @method static Builder|Area whereLevel($value)
 * @method static Builder|Area whereName($value)
 * @method static Builder|Area whereOriginalAreaId($value)
 * @method static Builder|Area whereOriginalParentAreaId($value)
 * @method static Builder|Area whereTotalUser($value)
 * @method static Builder|Area whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Area extends AbstractModel
{
    protected $table = 'areas';

    protected $fillable = [
        'original_area_id',
        'original_parent_area_id',
        'level',
        'name',
        'total_user',
    ];
}
