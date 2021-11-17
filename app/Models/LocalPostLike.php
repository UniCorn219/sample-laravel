<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalPostLike
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $localpost_id
 * @property int|null $localpost_comment_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike newQuery()
 * @method static Builder|LocalPostLike onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereLocalpostCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereLocalpostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostLike whereUserId($value)
 * @method static Builder|LocalPostLike withTrashed()
 * @method static Builder|LocalPostLike withoutTrashed()
 * @mixin Eloquent
 */
class LocalPostLike extends AbstractModel
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'localpost_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localpost_id',
        'localpost_comment_id',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
