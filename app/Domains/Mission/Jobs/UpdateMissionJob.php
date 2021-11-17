<?php

namespace App\Domains\Mission\Jobs;

use App\Models\UserMission;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class UpdateMissionJob extends Job
{
    private array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return Model|UserMission
     */
    public function handle(): UserMission|Model
    {
        return UserMission::create($this->data);
    }
}
