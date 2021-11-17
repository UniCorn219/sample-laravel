<?php

namespace App\Domains\User\Jobs;

use App\Models\InternetShopReview;
use Lucid\Units\Job;

class UpdateReviewInternetShopJob extends Job
{
    private int $userId;
    private int $reviewId;
    private array $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $reviewId, array $params)
    {
        $this->userId = $userId;
        $this->reviewId  = $reviewId;
        $this->params = $params;
    }

    /**
     * @return boolean
     */
    public function handle()
    {
        return InternetShopReview::query()
            ->where('user_id', $this->userId)
            ->where('id', $this->reviewId)
            ->update($this->params);
    }
}
