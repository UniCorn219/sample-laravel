<?php

namespace App\Domains\User\Jobs;

use App\Enum\CommonType;
use App\Models\LocalPost;
use Illuminate\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListUserBlockedFromAllPostJob extends Job
{
    private int $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return CursorPaginator
     */
    public function handle(): CursorPaginator
    {
        return LocalPost::query()
            ->where('author_id', $this->userId)
            ->join('localpost_blocking', 'localpost.id', '=', 'localpost_blocking.localpost_id')
            ->join('users', 'localpost_blocking.user_id', '=', 'users.id')
            ->select(['users.*'])
            ->distinct()
            ->orderByDesc('users.id')
            ->cursorPaginate(CommonType::PAGINATION);
    }
}
