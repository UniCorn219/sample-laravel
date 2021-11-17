<?php

namespace App\Domains\User\Jobs;

use App\Models\UserBlocking;
use Lucid\Units\Job;

class BlockAnotherUserJob extends Job
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
        $this->userId = $userId;
        $this->userTargetId = $userTargetId;
    }


    /**
     * Execute the job.
     *
     * @return UserBlocking
     */
    public function handle(): UserBlocking
    {
        $condition = [
            'user_id' => $this->userId,
            'user_target_id' => $this->userTargetId,
        ];

        return UserBlocking::query()->create($condition);
    }
}
