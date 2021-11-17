<?php

namespace App\Domains\User\Jobs;

use App\Models\UserReportUser;
use Lucid\Units\Job;

class UserReportUserJob extends Job
{
    private array $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return UserReportUser
     */
    public function handle(): UserReportUser
    {
        return UserReportUser::create($this->params);
    }
}
