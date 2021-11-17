<?php

namespace App\Domains\Mission\Jobs;

use App\Models\UserMission;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetUserMissionByUserIdJob extends Job
{
    private int $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return array|Collection
     */
    public function handle(): array|Collection
    {
        return UserMission::whereUserId($this->userId)->get();
    }
}
