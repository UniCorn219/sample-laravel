<?php

namespace App\Domains\Chatting\Jobs;

use App\Lib\Firestore\Model;
use App\Models\Firestore\StoreThread;
use Lucid\Units\Job;

class UpdateStoreThreadJob extends Job
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
        StoreThread::query()->update($this->values, $this->docId);

        return StoreThread::query()->find($this->docId);
    }
}
