<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class UserNicknameChange extends AbstractModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_nickname_changes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'nickname',
    ];
}
