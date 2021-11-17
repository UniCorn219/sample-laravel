<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Model;
use App\Models\Firestore;

/**
 * Class StoreThread
 * @package App\Models\Firestore
 * @property string $id
 * @property object { } $thread_key
 * @property string $phone
 * @property string $avatar
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class StoreThread extends Model
{
    protected string $collectionName = 'store_threads';

    protected array $fillable = [
        'id',
        'store_fuid',
        'other_user_fuid',
        'thread_fuid',
        'settings',
        'unread_count',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
