<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class GetUserFcmByFirebaseUIDJob extends Job
{
    private string $firebaseUid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $firebaseUid)
    {
        $this->firebaseUid = $firebaseUid;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): string
    {
        $user = User::query()->where('firebase_uid', $this->firebaseUid)->firstOrFail();
        return $user->token_fcm;
    }
}
