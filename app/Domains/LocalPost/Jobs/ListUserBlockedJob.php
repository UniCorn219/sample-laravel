<?php

namespace App\Domains\LocalPost\Jobs;

use App\Models\LocalPostBlocking;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Lucid\Units\Job;

class ListUserBlockedJob extends Job
{
    private int $limit;
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $limit, int $localpostId)
    {
        $this->id = $localpostId;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return CursorPaginator|Paginator
     */
    public function handle(): Paginator|CursorPaginator
    {
        return LocalPostBlocking::where('localpost_id', $this->id)
            ->with('user.address')
            ->orderByDesc('id')
            ->cursorPaginate($this->limit);
    }
}
