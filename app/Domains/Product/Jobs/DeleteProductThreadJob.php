<?php

namespace App\Domains\Product\Jobs;

use App\Models\ProductThread;
use Lucid\Units\Job;

class DeleteProductThreadJob extends Job
{
    public function __construct(
        private string $threadFuid
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): int
    {
        /** @var ProductThread|null $productThread */
        $productThread = ProductThread::where('thread_fuid', $this->threadFuid)->first();

        ProductThread::where('thread_fuid', $this->threadFuid)->delete();

        return $productThread->product_id ?? 0;
    }
}
