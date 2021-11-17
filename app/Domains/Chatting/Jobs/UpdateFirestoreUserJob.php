<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\User;
use Lucid\Units\QueueableJob;

class UpdateFirestoreUserJob extends QueueableJob
{
    private string $firebaseUid;
    private array  $values;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $firebaseUid, array $values)
    {
        $this->firebaseUid = $firebaseUid;
        $this->values      = $values;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::query()->update($this->values, $this->firebaseUid);
    }
}
