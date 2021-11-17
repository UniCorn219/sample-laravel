<?php

namespace App\Domains\User\Jobs;

use App\Models\InternetShopReview;
use Lucid\Units\Job;

class DeleteReviewInternetShopJob extends Job
{
    private int $userId;
    private int $reviewId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $reviewId)
    {
        $this->userId = $userId;
        $this->reviewId  = $reviewId;
    }

    /**
     * @return boolean
     */
    public function handle()
    {
        return InternetShopReview::query()
            ->where('user_id', $this->userId)
            ->where('id', $this->reviewId)
            ->delete();
    }
}
