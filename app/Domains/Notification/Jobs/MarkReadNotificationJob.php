<?php

namespace App\Domains\Notification\Jobs;

use App\Models\Notification;
use Lucid\Units\Job;

class MarkReadNotificationJob extends Job
{
    protected array $param;

    /**
     * MarkReadNotificationJob constructor.
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
        if (isset($this->param['mark_read_all']) && $this->param['mark_read_all']) {
            return Notification::query()
                ->where('receive_id', $this->param['user_id'])
                ->update([
                    'is_seen' => true,
                    'is_read' => true
                ]);
        }

        Notification::query()->where('receive_id', $this->param['user_id'])
            ->findOrFail($this->param['notification_id']);

        return Notification::query()
            ->where('receive_id', $this->param['user_id'])
            ->where('id', $this->param['notification_id'])
            ->update([
                'is_seen' => true,
                'is_read' => true
            ]);
    }
}
