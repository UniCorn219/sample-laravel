<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Model;

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
class Thread extends Model
{
    protected string $collectionName = 'threads';

    protected array $fillable = [
        'id',
        'key',
        'participants',
        'product',
        'last_message',
        'has_product',
        'status',
        'block_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Check thread's participants has store
     * @return bool
     */
    public function getIsStoreAttribute()
    {
        if (is_array($this->participants)) {
            foreach ($this->participants as $participant) {
                if (isset($participant['store'])) {
                    return true;
                }
            }
        }

        return false;
    }
}
