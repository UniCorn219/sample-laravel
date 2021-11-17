<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalInfoLike
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $localinfo_id
 * @property int|null $localinfo_comment_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike newQuery()
 * @method static Builder|LocalInfoLike onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereLocalinfoCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereLocalinfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoLike whereUserId($value)
 * @method static Builder|LocalInfoLike withTrashed()
 * @method static Builder|LocalInfoLike withoutTrashed()
 * @mixin Eloquent
 */
class LocalInfoLike extends AbstractModel
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'localinfo_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localinfo_id',
        'localinfo_comment_id',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function actionNotifications()
    {
        return $this->morphMany(NotificationObject::class, 'entityAction');
    }
}
