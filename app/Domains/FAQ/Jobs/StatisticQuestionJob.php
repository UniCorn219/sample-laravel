<?php

namespace App\Domains\FAQ\Jobs;

use App\Models\FaqQuestion;
use Lucid\Units\QueueableJob;

class StatisticQuestionJob extends QueueableJob
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $question = FaqQuestion::whereId($this->id)->useWritePdo()->lockForUpdate()->first();
        if ($question) {
            $question->total_views += 1;
            $question->save();
        }
    }
}
