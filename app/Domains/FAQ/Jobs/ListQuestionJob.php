<?php

namespace App\Domains\FAQ\Jobs;

use App\Models\FaqQuestion;
use Lucid\Units\Job;

class ListQuestionJob extends Job
{
    private int $id;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, int $limit)
    {
        $this->id     = $id;
        $this->limit  = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return FaqQuestion::query()
            ->where('faq_category_id', $this->id)
            ->cursorPaginate($this->limit);
    }
}
