<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserActionable
 *
 * @property int $id
 * @property int $user_id
 * @property int $target_id
 * @property int $target_type 1:USER,2:STORE..
 * @property int $action_type like, follow
 * @property string|null $note
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserActionable newModelQuery()
 * @method static Builder|UserActionable newQuery()
 * @method static Builder|UserActionable query()
 * @method static Builder|UserActionable whereActionType($value)
 * @method static Builder|UserActionable whereCreatedAt($value)
 * @method static Builder|UserActionable whereDeletedAt($value)
 * @method static Builder|UserActionable whereId($value)
 * @method static Builder|UserActionable whereNote($value)
 * @method static Builder|UserActionable whereTargetId($value)
 * @method static Builder|UserActionable whereTargetType($value)
 * @method static Builder|UserActionable whereUpdatedAt($value)
 * @method static Builder|UserActionable whereUserId($value)
 * @method static where(array $condition)
 * @mixin Eloquent
 */
class UserActionable extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'user_actionable';

    protected $fillable = [
        'user_id',
        'target_id',
        'target_type',
        'action_type',
        'note',
    ];

    public function followUser()
    {
        return $this->hasOne(User::class, 'id', 'target_id');
    }

    public function actionNotifications()
    {
        return $this->morphMany(NotificationObject::class, 'entityAction');
    }
}
