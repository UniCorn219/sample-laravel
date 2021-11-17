<?php

namespace App\Domains\User\Jobs;

use App\Models\UserReportReview;
use Lucid\Units\Job;

class UserReportReviewJob extends Job
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
     * @return UserReportReview
     */
    public function handle(): UserReportReview
    {
        return UserReportReview::create($this->params);
    }
}
