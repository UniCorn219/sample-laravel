<?php

namespace App\Domains\Product\Jobs;

use Lucid\Units\Job;
use App\Models\ProductTop;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class PushToTopJob extends Job
{
    private array $param;

    /**
     * PushToTopJob constructor.
     *
     * @param string $keyword
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return ProductTop|\Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        return DB::transaction(function() {
            $productTop = ProductTop::create($this->param);
            $product = Product::whereNull('blocked_by')->find($this->param['product_id']);
            if ($product) {
                $product->timestamps = false;
                $product->total_up_times += 1;
                $product->save();
            }
            return $productTop;
        });
    }
}
