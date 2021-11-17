<?php

namespace App\Domains\Chatting\Jobs;

use App\Lib\Firestore\Model;
use App\Models\Firestore\Message;
use Lucid\Units\Job;

class UpdateMessageJob extends Job
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
        Message::query()->update($this->values, $this->docId);

        return Message::query()->find($this->docId);
    }
}
