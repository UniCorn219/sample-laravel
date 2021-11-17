<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Product;
use Lucid\Units\Job;

class GetProductInfoJob extends Job
{
    private int $productId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     *
     * @return Product|null
     */
    public function handle(): Product|null
    {
        return Product::query()->where([
            'id'        => $this->productId,
        ])->firstOrFail();
    }
}
