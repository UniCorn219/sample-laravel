<?php

namespace App\Domains\Internal\Jobs;

use Lucid\Units\Job;

class TestJob extends Job
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
    public function handle(): array
    {
        return ($this->data);
    }
}
