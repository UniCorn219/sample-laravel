<?php

namespace App\Domains\Chatting\Jobs\User;

use App\Models\Firestore\User;
use Lucid\Units\Job;

class UpdateFirestoreUserJob extends Job
{
    private array $values;
    private string $docId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $values, $docId)
    {
        $this->values = $values;
        $this->docId = $docId;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle(): array
    {
        return User::query()->update($this->values, $this->docId);
    }
}
