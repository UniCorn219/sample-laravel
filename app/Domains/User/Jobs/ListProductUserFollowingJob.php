<?php

namespace App\Domains\User\Jobs;

use App\Enum\ProductStatus;
use App\Enum\UserActionableType;
use App\Models\Product;
use App\Models\UserActionable;
use Lucid\Units\Job;

class ListProductUserFollowingJob extends Job
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
     * Execute the job.
     *
     * @return \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Contracts\Pagination\Paginator
     */
    public function handle()
    {
        $userFollows = UserActionable::query()
            ->where('user_id', $this->userId)
            ->where('action_type', UserActionableType::ACTION_USER_FOLLOW)
            ->where('target_type', UserActionableType::ENTITY_USER)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->pluck('target_id')
            ->toArray();

        return Product::query()
            ->with(['owner.address', 'images', 'category'])
            ->whereIn('author_id', $userFollows)
            ->whereIn('status', [ProductStatus::SELLING, ProductStatus::RESERVED])
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->cursorPaginate($this->limit);
    }
}
