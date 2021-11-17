<?php

namespace App\Domains\Product\Jobs;

use App\Models\ProductPaymentMethod;
use Illuminate\Support\Carbon;
use Lucid\Units\Job;

class SyncProductPaymentMethodJob extends Job
{
    public function __construct(
        private int $id,
        private array $methods,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        ProductPaymentMethod::where('product_id', $this->id)->delete();

        $data = collect($this->methods)->map(function ($method) {
            return [
                'product_id'     => $this->id,
                'payment_method' => $method,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ];
        })
            ->toArray();

        ProductPaymentMethod::insert($data);
    }
}
