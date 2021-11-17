<?php

namespace App\Domains\User\Jobs;

use App\Models\InternetShopReview;
use Lucid\Units\Job;

class ListReviewInternetShopJob extends Job
{
    private int $userId;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $limit)
    {
        $this->userId = $userId;
        $this->limit  = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return InternetShopReview::query()
            ->with(['internetShop'])
            ->where('user_id', $this->userId)
            ->orderBy('id', 'DESC')
            ->cursorPaginate($this->limit);
    }
}
