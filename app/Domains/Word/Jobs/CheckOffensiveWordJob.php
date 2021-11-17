<?php

namespace App\Domains\Word\Jobs;

use App\Models\OffensiveWord;
use Lucid\Units\Job;

class CheckOffensiveWordJob extends Job
{
    private string $content;

    /**
     * Create a new job instance.
     *
     * @param  string  $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $count = OffensiveWord::whereRaw("strpos(?, word) > 0", [strtolower($this->content)])
            ->count();

        return $count > 0;
    }
}
