<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Lucid\Units\Job;

class UpdateProductStatusJob extends Job
{
    public function __construct(private int $id, private int $status)
    {}

    /**
     * Execute the job.
     */
    public function handle()
    {
        Product::where('id', $this->id)->update(['status' => $this->status]);
    }
}
