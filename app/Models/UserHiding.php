<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserHiding
 *
 * @property int $id
 * @property int $user_id
 * @property int $type 1: product, 2: localpost
 * @property int $user_target_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserHiding newModelQuery()
 * @method static Builder|UserHiding newQuery()
 * @method static Builder|UserHiding query()
 * @method static Builder|UserHiding whereCreatedAt($value)
 * @method static Builder|UserHiding whereId($value)
 * @method static Builder|UserHiding whereType($value)
 * @method static Builder|UserHiding whereUpdatedAt($value)
 * @method static Builder|UserHiding whereUserId($value)
 * @method static Builder|UserHiding whereUserTargetId($value)
 * @mixin Eloquent
 */
class UserHiding extends AbstractModel
{
    use HasFactory;
    protected $table = 'user_hidings';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'type',
        'user_target_id',
    ];
}
