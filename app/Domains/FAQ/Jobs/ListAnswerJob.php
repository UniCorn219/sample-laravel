<?php

namespace App\Domains\FAQ\Jobs;

use App\Models\FaqAnswer;
use App\Models\FaqQuestion;
use Lucid\Units\Job;

class ListAnswerJob extends Job
{
    private int $id;
    private int $questionId;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, int $questionId, int $limit)
    {
        $this->id         = $id;
        $this->questionId = $questionId;
        $this->limit      = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return FaqQuestion::query()
            ->with('answers')
            ->where('id', $this->questionId)
            ->where('faq_category_id', $this->id)
            ->cursorPaginate($this->limit);
    }
}
