<?php

namespace App\Domains\UserReviewable\Jobs;

use App\Enum\UserReviewableType;
use App\Models\UserReviewable;
use DB;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Lucid\Units\Job;
use Illuminate\Pagination\CursorPaginator;

class ListUserReviewableJob extends Job
{
    private int $targetId;
    private array $query;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $targetId, array $query)
    {
        $this->targetId = $targetId;
        $this->query = $query;
    }

    /**
     * Execute the job.
     *
     * @return Paginator|CursorPaginator
     */
    public function handle(): Paginator|CursorPaginator
    {
        $type = (int) Arr::get($this->query, 'type', UserReviewableType::USER);
        $limit = (int) Arr::get($this->query, 'limit', 10);
        $limit = min(50, $limit);
        $targetId = $this->targetId;

        UserReviewable::$relationType = $type;
        return UserReviewable::query()
            ->where([
                'target_id' => $targetId,
                'review_type' => $type,
            ])
            ->whereNull('reply_id')
            ->with(['owner.address', 'targetData', 'replies'])
            ->orderByDesc('id')
            ->cursorPaginate($limit);
    }
}
