<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalPostComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $localpost_id
 * @property int|null $reply_id
 * @property int $total_like
 * @property string $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|LocalPostLike[] $likes
 * @property-read int|null $likes_count
 * @property-read Collection|LocalPostComment[] $replies
 * @property-read int|null $replies_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment newQuery()
 * @method static Builder|LocalPostComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereLocalpostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostComment whereUserId($value)
 * @method static Builder|LocalPostComment withTrashed()
 * @method static Builder|LocalPostComment withoutTrashed()
 * @mixin Eloquent
 */
class LocalPostComment extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localpost_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localpost_id',
        'total_like',
        'reply_id',
        'content',
    ];

    protected $appends = [
        'total_reply'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(LocalPostComment::class, 'reply_id', 'id')
            ->with('user.address')
            ->orderByDesc('id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LocalPostLike::class, 'id', 'localpost_comment_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(LocalPost::class, 'localpost_id');
    }

    public function getTotalReplyAttribute($key)
    {
        return count($this->replies);
    }

    public function liked()
    {
        if (auth()->id()) {
            return $this->hasOne(LocalPostLike::class, 'localpost_comment_id')
                ->where('user_id', auth()->id());
        }

        return null;
    }

    public function notifications()
    {
        return $this->morphMany(NotificationObject::class, 'entity');
    }

    public function actionNotifications()
    {
        return $this->morphMany(NotificationObject::class, 'entityAction');
    }
}
