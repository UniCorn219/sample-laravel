<?php

namespace App\Domains\User\Jobs;

use App\Models\LocalInfo;
use App\Models\LocalInfoLike;
use Lucid\Units\Job;

class ListLocalInfoUserLikedJob extends Job
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
        return LocalInfo::query()
            ->select('localinfo.*')
            ->with(['category', 'store', 'images'])
            ->join('localinfo_likes', 'localinfo.id', '=', 'localinfo_likes.localinfo_id')
            ->where('localinfo_likes.user_id', $this->userId)
            ->whereNull('localinfo.deleted_at')
            ->whereNull('localinfo_likes.deleted_at')
            ->orderByDesc('localinfo_likes.created_at')
            ->cursorPaginate($this->limit);
    }
}
