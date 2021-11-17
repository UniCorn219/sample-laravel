<?php

namespace App\Domains\Product\Jobs;

use App\Models\ProductThread;
use Lucid\Units\Job;

class RestoreProductThreadJob extends Job
{
    public function __construct(
        private string $threadFuid
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        ProductThread::where('thread_fuid', $this->threadFuid)->update(['deleted_at' => null]);
    }
}
