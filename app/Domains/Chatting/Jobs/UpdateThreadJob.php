<?php

namespace App\Domains\Chatting\Jobs;

use App\Lib\Firestore\Model;
use App\Models\Firestore\Thread;
use Lucid\Units\QueueableJob;

class UpdateThreadJob extends QueueableJob
{
    private string $docId;
    private array $values;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $docId, array $values)
    {
        $this->docId = $docId;
        $this->values = $values;
    }

    /**
     * Execute the job.
     *
     * @return Model
     */
    public function handle()
    {
        Thread::query()->update($this->values, $this->docId);

        return Thread::query()->find($this->docId);
    }
}
