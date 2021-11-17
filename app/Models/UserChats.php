<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserChats
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_target_id
 * @property bool $user_reply
 * @property bool $is_from_product
 * @property string $thread_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats newQuery()
 * @method static Builder|UserChats onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereUserReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereUserTargetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserChats whereThreadId($value)
 * @method static Builder|UserChats withTrashed()
 * @method static Builder|UserChats withoutTrashed()
 * @mixin Eloquent
 */
class UserChats extends AbstractModel
{
    protected $table = 'user_chats';

    protected $fillable = [
        'user_id',
        'user_target_id',
        'thread_id',
        'user_reply',
        'is_from_product',
    ];
}
