<?php

namespace App\Domains\User\Jobs;

use App\Enum\CommonType;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListReferUserJob extends Job
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
        return User::where('refer_user', $this->userId)
            ->cursorPaginate(CommonType::PAGINATION);
    }
}
