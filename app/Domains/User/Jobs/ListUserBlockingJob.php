<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserActionableType;
use App\Models\User;
use App\Models\UserActionable;
use App\Models\UserBlocking;
use Lucid\Units\Job;

class ListUserBlockingJob extends Job
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
        $userBlockings =  UserBlocking::query()
            ->where('user_id', $this->userId)
            ->pluck('user_target_id')
            ->toArray();

        return User::query()
            ->whereIn('id', $userBlockings)
            ->whereNull('deleted_at')
            ->with('address')
            ->cursorPaginate($this->limit);
    }
}
