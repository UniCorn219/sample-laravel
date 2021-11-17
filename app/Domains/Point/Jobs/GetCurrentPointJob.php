<?php

namespace App\Domains\Point\Jobs;

use App\Models\User;
use Lucid\Units\Job;
use Throwable;

class GetCurrentPointJob extends Job
{
    private int $userId;

    /**
     * Create a new job instance.
     *
     * @param  int  $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): int
    {
        $user = User::find($this->userId);

        return (int) ($user->total_point ?? 0);
    }
}
