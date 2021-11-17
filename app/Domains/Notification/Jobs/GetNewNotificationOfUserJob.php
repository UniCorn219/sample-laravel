<?php

namespace App\Domains\Notification\Jobs;

use App\Models\Notification;
use Lucid\Units\Job;


class GetNewNotificationOfUserJob extends Job
{
    private int $userId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Notification::where('notifications.receive_id', $this->userId)
            ->where('is_seen', FALSE)
            ->exists();
    }
}
