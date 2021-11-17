<?php

namespace App\Domains\Chatting\Jobs\Thread;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Firestore\Thread;
use Lucid\Units\Job;
use Throwable;

class GetThreadInfoJob extends Job
{
    private string $threadFuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the job.
     *
     * @return array
     * @throws Throwable
     */
    public function handle(): array
    {
        $thread = Thread::query()->find($this->threadFuid);

        throw_if(empty($thread), ResourceNotFoundException::class);

        return $thread->toArray();
    }
}
