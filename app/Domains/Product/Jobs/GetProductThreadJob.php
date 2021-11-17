<?php

namespace App\Domains\Product\Jobs;

use App\Models\ProductThread;
use Lucid\Units\Job;

class GetProductThreadJob extends Job
{
    private int    $productId;
    private string $threadFuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $productId, string $threadFuid)
    {
        $this->productId  = $productId;
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        return ProductThread::query()
                            ->where('product_id', $this->productId)
                            ->where('thread_fuid', $this->threadFuid)
                            ->first();
    }
}
