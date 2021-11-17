<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class FindOrFailProductDetailJob extends Job
{
    private int $id;
    private array $with = [];

    public function __construct(int $id, array $with = [])
    {
        $this->id   = $id;
        $this->with = $with ?: $this->with;
    }

    public function handle(): Model|Product
    {
        $promotion = Product::findOrFail($this->id);

        return $promotion->load($this->with);
    }
}
