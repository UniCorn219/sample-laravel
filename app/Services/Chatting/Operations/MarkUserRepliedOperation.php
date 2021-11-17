<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\GetUserChatDetailByThreadIdJob;
use App\Domains\Chatting\Jobs\UpdateUserChatsJob;
use Lucid\Units\QueueableOperation;

class MarkUserRepliedOperation extends QueueableOperation
{
    private int $userId;
    private string $threadId;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(int $userId, string $threadId)
    {
        $this->userId = $userId;
        $this->threadId = $threadId;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $threadDetail = $this->run(GetUserChatDetailByThreadIdJob::class, [
            'threadId' => $this->threadId,
        ]);

        if ($threadDetail && ($threadDetail->user_reply === false) && ($threadDetail->user_target_id === $this->userId)) {
            $this->run(UpdateUserChatsJob::class, ['threadId' => $this->threadId]);
        }
    }
}
