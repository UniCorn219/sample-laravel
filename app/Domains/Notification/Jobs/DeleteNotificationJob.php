<?php

namespace App\Domains\Notification\Jobs;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;

class DeleteNotificationJob extends Job
{
    private $param;

    /**
     *
     * DeleteNotificationJob constructor.
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        if (isset($this->param['is_remove_all']) && $this->param['is_remove_all']) {
            $listIdNotificationDelete = Notification::query()
                ->select('notifications.id')
                ->join('notification_objects', 'notification_objects.id', '=', 'notifications.notification_object_id')
                ->where('receive_id', $this->param['user_id']);

            if (isset($this->param['is_notification_keyword']) && $this->param['is_notification_keyword']) {
                $listIdNotificationDelete = $listIdNotificationDelete->whereNotNull('notification_objects.keyword');
            } else {
                $listIdNotificationDelete = $listIdNotificationDelete->whereNull('notification_objects.keyword');
            }

            $listIdNotificationDelete = $listIdNotificationDelete->get()->pluck('id');

            if ($listIdNotificationDelete->isEmpty()) {
                return true;
            }

            Notification::query()->whereIn('id', $listIdNotificationDelete)->delete();
        } else {
            Notification::query()->where('receive_id', $this->param['user_id'])
                ->findOrFail($this->param['notification_id']);

            Notification::query()
                ->where('receive_id', $this->param['user_id'])
                ->where('id', $this->param['notification_id'])
                ->delete();
        }

        return true;
    }
}
