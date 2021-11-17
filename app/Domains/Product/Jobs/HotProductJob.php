<?php

namespace App\Domains\Product\Jobs;

use App\Criteria\ProductCriteria;
use App\Enum\ProductStatus;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class HotProductJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @return array|Collection
     */
    public function handle(): array|Collection
    {
        $userData = UserAddress::query()->where('user_id', $this->param['user_id'])->first();

        if (!$userData) {
            return [];
        }

        $emdAreaId = $userData->emd_area_id;
        $query = [
            'emd_area_id' => $emdAreaId
        ];

        $productQuery = Product::with('owner.address', 'images', 'category')
            ->whereNull('blocked_by');
        (new ProductCriteria($query))->apply($productQuery);

        return $productQuery->whereIn('status', [
                ProductStatus::SELLING,
            ])
            ->limit(Product::LIMIT_HOT_PRODUCT)
            ->orderBy('products.id', 'DESC')
            ->get();
    }
}
