<?php

namespace App\Domains\LocalPost\Jobs;

use App\Models\LocalPost;
use Lucid\Units\Job;

class GetSimpleLocalPostJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $ids)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return LocalPost::whereIn('id', $this->ids)->get();
    }
}
