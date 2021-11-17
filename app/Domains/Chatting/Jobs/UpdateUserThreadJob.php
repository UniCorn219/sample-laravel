<?php

namespace App\Domains\Chatting\Jobs;

use App\Lib\Firestore\Model;
use App\Models\Firestore\UserThread;
use Lucid\Units\Job;

class UpdateUserThreadJob extends Job
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
    public function handle(): Model
    {
        UserThread::query()->update($this->values, $this->docId);

        return UserThread::query()->find($this->docId);
    }
}
