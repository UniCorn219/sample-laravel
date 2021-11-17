<?php

namespace App\Domains\User\Jobs;

use App\Models\LocalPost;
use Lucid\Units\Job;

class GetLocalPostOtherUserJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return LocalPost::with(['category'])
            ->where('author_id', $this->param['other_user_id'])
            ->orderByDesc('id')
            ->cursorPaginate($limit);
    }
}
