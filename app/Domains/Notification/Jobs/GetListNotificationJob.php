<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\NotificationAction;
use App\Models\Notification;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListNotificationJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return CursorPaginator
     */
    public function handle(): CursorPaginator
    {
        $query = Notification::query()
            ->join('notification_objects', 'notification_objects.id', '=', 'notifications.notification_object_id')
            ->whereIn('notification_objects.action_type', [
                NotificationAction::REVIEW_COMPLETE_TRANSACTION,
                NotificationAction::REVIEW_STORE,
                NotificationAction::FOLLOW_USER,
                NotificationAction::PRODUCT_PUSH_TO_TOP,
                NotificationAction::LIKE_PRODUCT,
                NotificationAction::LIKE_LOCAL_POST,
                NotificationAction::LIKE_LOCAL_INFO,
                NotificationAction::LIKE_COMMENT_LOCAL_INFO,
                NotificationAction::LIKE_COMMENT_LOCAL_POST,
                NotificationAction::REPLY_COMMENT_LOCAL_POST,
                NotificationAction::REPLY_COMMENT_LOCAL_INFO,
                NotificationAction::COMMENT_LOCAL_INFO,
                NotificationAction::COMMENT_LOCAL_POST,
                NotificationAction::CREATE_RESERVATION,
                NotificationAction::UPDATE_RESERVATION,
                NotificationAction::DELETE_RESERVATION,
                NotificationAction::REMINDER_RESERVATION,
                NotificationAction::BATTERY_LEVEL_UP,
                NotificationAction::DONE_MISSION,
                NotificationAction::INVITE_MEMBER,
                NotificationAction::INVITE_9_MEMBER,
                NotificationAction::PRODUCT_CHANGED,
                NotificationAction::BUYER_BUY_PRODUCT,
                NotificationAction::BUYER_CANCEL_PRODUCT,
                NotificationAction::BUYER_COMPLETE_PRODUCT,
                NotificationAction::AUTO_CANCEL_PRODUCT,
            ])
            ->with(['notificationObject.entityAction', 'notificationObject.notificationChange.actor'])
            ->with(['notificationObject.entity' => function ($query) {
                $query->with(['images']);
            }])
            ->with(['notificationObject.entity', 'notificationObject.entityAction', 'notificationObject.notificationChange.actor'])
            ->where('notifications.receive_id', $this->param['user_id'])
            ->select('notifications.*')
            ->orderByDesc('notifications.created_at');

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->cursorPaginate($limit);
    }
}
