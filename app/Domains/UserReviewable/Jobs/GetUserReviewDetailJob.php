<?php

namespace App\Domains\UserReviewable\Jobs;

use App\Models\UserReviewable;
use Lucid\Units\Job;

class GetUserReviewDetailJob extends Job
{
    private int $userId;
    private int $targetId;
    private int $reviewType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $targetId, int $reviewType)
    {
        $this->userId = $userId;
        $this->targetId = $targetId;
        $this->reviewType = $reviewType;
    }

    /**
     * Execute the job.
     *
     * @return UserReviewable|null
     */
    public function handle(): UserReviewable|null
    {
        return UserReviewable::where([
            'user_id' => $this->userId,
            'target_id' => $this->targetId,
            'review_type' => $this->reviewType
        ])->first();
    }
}
