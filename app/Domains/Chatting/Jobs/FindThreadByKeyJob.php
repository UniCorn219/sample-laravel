<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Thread;
use Lucid\Units\Job;

class FindThreadByKeyJob extends Job
{
    private string $key;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle(): mixed
    {
        return Thread::query()->where('key', $this->key)->first();
    }
}
