<?php

namespace App\Domains\User\Jobs;

use App\Models\LocalPost;
use App\Models\LocalPostLike;
use Lucid\Units\Job;

class ListLocalPostUserLikedJob extends Job
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
        return LocalPost::query()
            ->select('localpost.*')
            ->with(['category', 'owner.address', 'images'])
            ->join('localpost_likes', 'localpost.id', '=', 'localpost_likes.localpost_id')
            ->where('localpost_likes.user_id', $this->userId)
            ->whereNull('localpost.deleted_at')
            ->whereNull('localpost_likes.deleted_at')
            ->orderByDesc('localpost_likes.created_at')
            ->cursorPaginate($this->limit);
    }
}
