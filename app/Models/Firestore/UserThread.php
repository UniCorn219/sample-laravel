<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Model;
use App\Models\Firestore;

/**
 * Class Thread
 * @package App\Models\Firestore
 * @property string $id
 * @property object { } $thread_key
 * @property string $phone
 * @property string $avatar
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class UserThread extends Model
{
    protected string $collectionName = 'user_threads';

    protected array $fillable = [
        'id',
        'user_fuid',
        'other_user_fuid',
        'thread_fuid',
        'settings',
        'unread_count',
        'is_store',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
