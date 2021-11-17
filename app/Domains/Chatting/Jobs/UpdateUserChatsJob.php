<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\UserChats;
use Lucid\Units\Job;

class UpdateUserChatsJob extends Job
{
    private string $threadId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $threadId)
    {
        $this->threadId = $threadId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userChat = UserChats::where('thread_id', $this->threadId)->first();

        if (!$userChat->user_reply) {
            $userChat->user_reply = true;
            $userChat->save();
        }
    }
}
