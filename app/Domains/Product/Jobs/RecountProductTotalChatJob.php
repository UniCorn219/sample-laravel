<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use App\Models\ProductThread;
use Lucid\Units\Job;

class RecountProductTotalChatJob extends Job
{
    public function __construct(
        private int $id
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $count = ProductThread::where('product_id', $this->id)->count();

        Product::where('id', $this->id)
            ->update(['total_chat_count' => $count]);
    }
}
