<?php

namespace App\Domains\FAQ\Jobs;

use App\Models\FaqCategory;
use Lucid\Units\Job;

class ListFaqCategoryJob extends Job
{
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return FaqCategory::query()->cursorPaginate($this->limit);
    }
}
