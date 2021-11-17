<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserMission
 *
 * @property int $id
 * @property int $user_id
 * @property int $mission_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserMission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereMissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMission whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserMission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserMission withoutTrashed()
 * @mixin \Eloquent
 */
class UserMission extends AbstractModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_missions';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'mission_id',
    ];
}
