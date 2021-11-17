<?php

namespace App\Domains\Product\Jobs;

use Lucid\Units\Job;
use App\Models\ProductTop;


class GetProductTopJob extends Job
{
    private array $param;

    /**
     * GetProductTopJob constructor.
     *
     * @param string $keyword
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return Void
     */
    public function handle()
    {
        return ProductTop::where('product_id', $this->param['product_id'])->first();
    }
}
