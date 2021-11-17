<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\User;
use App\Models\UserChats;
use Lucid\Units\Job;

class CreateUserChatsJob extends Job
{
    private int $userId;
    private int $userTargetId;
    private string $threadId;
    private bool $isFromProduct;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $userTargetId, string $threadId, bool $isFromProduct)
    {
        $this->userId = $userId;
        $this->userTargetId = $userTargetId;
        $this->threadId = $threadId;
        $this->isFromProduct = $isFromProduct;
    }

    /**
     * Execute the job.
     *
     * @return UserChats
     */
    public function handle(): UserChats
    {
        return UserChats::create([
            'user_id' => $this->userId,
            'user_target_id' => $this->userTargetId,
            'thread_id' => $this->threadId,
            'is_from_product' => $this->isFromProduct
        ]);
    }
}
