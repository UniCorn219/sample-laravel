<?php

namespace App\Domains\User\Jobs;

use App\Models\UserBlocking;
use Lucid\Units\Job;

class UnblockAnotherUserJob extends Job
{
    private int $userTargetId;
    private int $userId;

    /**
     * BlockAnotherUserJob constructor.
     *
     * @param int $userId
     * @param int $userTargetId
     */
    public function __construct(int $userId, int $userTargetId)
    {
        $this->userId       = $userId;
        $this->userTargetId = $userTargetId;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle(): int
    {
        $conditions = [
            'user_id'        => $this->userId,
            'user_target_id' => $this->userTargetId,
        ];

        return UserBlocking::query()->where($conditions)->delete();
    }
}
