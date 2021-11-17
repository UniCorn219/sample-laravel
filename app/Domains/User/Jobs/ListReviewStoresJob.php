<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserReviewableType;
use App\Models\UserReviewable;
use Lucid\Units\Job;

class ListReviewStoresJob extends Job
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
        return UserReviewable::query()
            ->with(['store.addressMap', 'owner.address'])
            ->where('user_id', $this->userId)
            ->whereNull('deleted_at')
            ->where('review_type', UserReviewableType::STORE)
            ->orderBy('id', 'DESC')
            ->cursorPaginate($this->limit);
    }
}
