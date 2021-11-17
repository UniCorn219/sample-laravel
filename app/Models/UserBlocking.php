<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserBlocking
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_target_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserBlocking newModelQuery()
 * @method static Builder|UserBlocking newQuery()
 * @method static Builder|UserBlocking query()
 * @method static Builder|UserBlocking whereCreatedAt($value)
 * @method static Builder|UserBlocking whereId($value)
 * @method static Builder|UserBlocking whereUpdatedAt($value)
 * @method static Builder|UserBlocking whereUserId($value)
 * @method static Builder|UserBlocking whereUserTargetId($value)
 * @method static where(array $condition)
 * @mixin Eloquent
 */
class UserBlocking extends AbstractModel
{
    use HasFactory;
    protected $table = 'user_blocking';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'user_target_id',
    ];

    /**
     * @return HasOne
     */
    public function targetUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_target_id');
    }
}
