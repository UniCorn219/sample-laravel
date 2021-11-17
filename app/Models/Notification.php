<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static insert(array $array)
 */
class Notification extends AbstractModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    public $timestamps = true;

//    protected $casts = [
//        'created_at' => 'datetime:Y-m-d H:i:s',
//        'updated_at' => 'datetime:Y-m-d H:i:s',
//    ];

    protected $fillable = [
        'notification_object_id',
        'receive_id',
        'is_seen',
        'is_read'
    ];

    public function notificationObject()
    {
        return $this->belongsTo(NotificationObject::class, 'notification_object_id', 'id');
    }
}
