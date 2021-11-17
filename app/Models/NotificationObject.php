<?php

namespace App\Models;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static insert(array $array)
 * @method static insertGetId(array $array)
 */
class NotificationObject extends Model
{
    use HasFactory, SoftDeletes;

    const POST = [
          'LIKE'    => 1,
          'COMMENT' => 2,
    ];

    const COMMENT = [
        'LIKE'  => 3,
        'REPLY' => 4,
    ];

    public $timestamps = true;

//    protected $casts = [
//        'created_at' => 'datetime:Y-m-d H:i:s',
//        'updated_at' => 'datetime:Y-m-d H:i:s',
//    ];

    protected $table = 'notification_objects';

    protected $fillable = [
        'entity_type',
        'action_type',
        'entity_id',
        'status',
        'keyword'
    ];

    protected $appends = [
        'image_notification'
    ];

    public function getImageNotificationAttribute(): mixed
    {
        if (!($this->entity_type == EntityMorphType::PRODUCT && in_array($this->action_type, [
                NotificationAction::REVIEW_COMPLETE_TRANSACTION,
                NotificationAction::PRODUCT_PUSH_TO_TOP,
                NotificationAction::LIKE_PRODUCT,
                NotificationAction::MATCH_KEYWORD,
            ]))) {
            return [];
        }

        $product = Product::find($this->entity_id);

        if (is_null($product)) {
            return [];
        }

        return $product->images;
    }

    public function postComment()
    {
        return $this->hasOne(PostComment::class, 'id', 'entity_id');
    }

    public function notification()
    {
        return $this->hasMany(Notification::class, 'notification_object_id', 'id');
    }

    public function notificationChange()
    {
        return $this->hasOne(NotificationChange::class, 'notification_object_id', 'id');
    }

    public function entity()
    {
        return $this->morphTo()->withTrashed();
    }

    public function entityAction()
    {
        return $this->morphTo(__FUNCTION__, 'entity_action_type', 'entity_action_id');
    }
}
