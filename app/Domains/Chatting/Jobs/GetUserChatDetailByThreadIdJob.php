<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\UserChats;
use Lucid\Units\Job;

class GetUserChatDetailByThreadIdJob extends Job
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
     * @return UserChats|null
     */
    public function handle(): ?UserChats
    {
        return UserChats::where('thread_id', $this->threadId)->first();
    }
}
