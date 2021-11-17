<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalPostReport
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $localpost_id
 * @property string $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $localpost_comment_id
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport newQuery()
 * @method static Builder|LocalPostReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereLocalpostCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereLocalpostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPostReport whereUserId($value)
 * @method static Builder|LocalPostReport withTrashed()
 * @method static Builder|LocalPostReport withoutTrashed()
 * @mixin Eloquent
 */
class LocalPostReport extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localpost_reports';

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
        'content',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
