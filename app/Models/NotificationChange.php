<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $array)
 */
class NotificationChange extends Model
{
    use HasFactory;

    protected $table = 'notification_changes';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'notification_object_id',
        'actor_id',
        'status'
    ];

    public function actor()
    {
        return $this->hasOne(User::class, 'id', 'actor_id');
    }
}
