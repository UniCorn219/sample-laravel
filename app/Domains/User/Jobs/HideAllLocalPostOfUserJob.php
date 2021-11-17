<?php

namespace App\Domains\User\Jobs;

use App\Models\UserHiding;
use Lucid\Units\Job;

class HideAllLocalPostOfUserJob extends Job
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
     * @return boolean
     */
    public function handle(): bool
    {
        $result = UserHiding::where($this->data)->first();

        if ($result) {
            $result->delete();
            return false;
        } else {
            UserHiding::create($this->data);
        }

        return true;
    }
}
