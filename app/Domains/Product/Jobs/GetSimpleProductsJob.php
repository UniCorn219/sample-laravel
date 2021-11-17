<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Illuminate\Support\Collection;
use Lucid\Units\Job;


class GetSimpleProductsJob extends Job
{
    public function __construct(private array $ids)
    {
    }

    public function handle(): Collection
    {
        return Product::whereIn('id', $this->ids)->get();
    }
}
