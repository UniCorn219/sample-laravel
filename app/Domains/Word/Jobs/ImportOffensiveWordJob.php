<?php

namespace App\Domains\Word\Jobs;

use App\Models\OffensiveWord;
use Lucid\Units\Job;

class ImportOffensiveWordJob extends Job
{
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param  array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        return OffensiveWord::upsert($this->data, ['word', 'language_code'], ['word', 'language_code']);
    }
}
