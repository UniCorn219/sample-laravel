<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetProductDetailJob extends Job
{
    /**
     * @var int id
     */
    private int $id;

    /**
     * GetProductDetailJob constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return Product
     */
    public function handle(): Product
    {
        $query = DB::raw(
            "(CASE WHEN product_tops.created_at IS NULL THEN products.updated_at ELSE product_tops.created_at END) as product_updated_at"
        );

        $product = Product::withTrashed()
            ->leftJoin('product_tops', 'products.id', '=', 'product_tops.product_id')
            ->select(['products.*'])
            ->addSelect($query)
            ->findOrFail($this->id);

        return $product->load([
            'owner.address',
            'emdArea',
            'emdArea.siggArea',
            'emdArea.siggArea.sidoArea',
            'images',
            'category',
            'buyer:id,uniqid,name,avatar,phone,birth,gender,nickname',
            'transactionable.transaction',
            'paymentMethods',
        ]);
    }
}
