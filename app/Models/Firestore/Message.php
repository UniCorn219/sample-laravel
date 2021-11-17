<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Model;

class Message extends Model
{
    protected string $collectionName = 'messages';

    protected array $fillable = [
        'id',
        'type',
        'text',
        'attachment',
        'sticker',
        'sender',
        'address',
        'reservation',
        'thread_fuid',
        'is_read',
        'created_at',
        'updated_at',
        'bank_account',
        'shipping_address',
        'reviewer_ids',
    ];
}
