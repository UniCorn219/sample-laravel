<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use App\Models\UserBlocking;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Lucid\Units\Job;

class GetListUserBlockedJob extends Job
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
     * @return Paginator|CursorPaginator
     */
    public function handle(): Paginator|CursorPaginator
    {
        User::findOrFail($this->userId);

        return UserBlocking::where('user_id', $this->userId)
            ->with('targetUser')
            ->orderByDesc('id')
            ->cursorPaginate(UserBlocking::PAGINATE_LIMIT_DEFAULT);
    }
}
