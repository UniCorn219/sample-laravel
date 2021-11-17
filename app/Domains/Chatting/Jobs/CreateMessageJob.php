<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Message;
use Lucid\Units\Job;

class CreateMessageJob extends Job
{
    private array $attributes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): string
    {
        return Message::query()->insertGetId($this->attributes);
    }
}
