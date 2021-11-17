<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\NotificationAction;
use App\Models\Notification;
use Lucid\Units\Job;

class ListNotificationKeywordSettingJob extends Job
{
    private int $userId;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $limit)
    {
        $this->userId = $userId;
        $this->limit  = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        $query = Notification::query()
            ->join('notification_objects', 'notification_objects.id', '=', 'notifications.notification_object_id')
            ->whereIn('notification_objects.action_type', [
                NotificationAction::MATCH_KEYWORD
            ])
            ->with(['notificationObject.entityAction', 'notificationObject.notificationChange.actor'])
            ->with(['notificationObject.entity' => function ($query) {
                $query->with(['images']);
            }])
            ->with(['notificationObject.entity', 'notificationObject.entityAction', 'notificationObject.notificationChange.actor'])
            ->where('notifications.receive_id', $this->userId)
            ->select('notifications.*')
            ->orderByDesc('notifications.created_at');

        $limit = $this->limit ?? 10;
        $limit = min(50, $limit);

        return $query->cursorPaginate($limit, ['notifications.*']);
    }
}
