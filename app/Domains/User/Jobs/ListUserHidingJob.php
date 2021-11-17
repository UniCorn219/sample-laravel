<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Lucid\Units\Job;

class ListUserHidingJob extends Job
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
        $this->limit = $limit;
    }

    /**
     * @return CursorPaginator
     */
    public function handle(): CursorPaginator
    {
        return User::query()
            ->join('user_hidings', function ($join) {
                $join->on('users.id', '=', 'user_hidings.user_target_id')
                    ->where('user_hidings.user_id', $this->userId);
            })
            ->select('users.*')
            ->with('address')
            ->distinct()
            ->cursorPaginate($this->limit);
    }
}
