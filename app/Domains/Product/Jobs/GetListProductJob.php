<?php

namespace App\Domains\Product\Jobs;

use App\Criteria\ProductCriteria;
use App\Enum\ProductStatus;
use App\Enum\UserHidingType;
use App\Models\Product;
use App\Models\UserBlocking;
use App\Models\UserHiding;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use App\Enum\FiltterProductList;

class GetListProductJob extends Job
{
    protected array $query;
    private int     $authId;

    /**
     * Create a new job instance.
     *
     * @param array $query
     * @param int $authId
     */
    public function __construct(array $query, int $authId)
    {
        $this->query  = $query;
        $this->authId = $authId;
    }

    /**
     * Execute the job.
     *
     * @return CursorPaginator
     */
    public function handle(): CursorPaginator
    {
        $query    = $this->query;
        $limit    = $query['limit'] ?? 10;
        $limit    = min($limit, 50);

        $location            = $query['location'] ?? null;
        $sortBy              = $query['sort_by'] ?? null;
        $sortType            = $query['sort_type'] ?? 'desc';
        $locationSelectQuery = DB::raw(
            "concat_ws(',', ST_Y(location::geometry),ST_X(location::geometry)) as location"
        );

        $productQuery = Product::with('owner.address', 'images', 'category')
            ->select(['products.*'])
            ->whereNull('blocked_by')
            ->addSelect($locationSelectQuery);

        $query['status'] = [
            ProductStatus::SELLING
        ];

        if (!empty($this->authId)) {
            $hideLocalPostByAuthor = UserHiding::query()->where([
                'user_id' => $this->authId,
                'type'    => UserHidingType::PRODUCT
            ])->get()->pluck('user_target_id')->toArray();

            $userBlockingIds = UserBlocking::query()
                ->where(['user_id' => $this->authId])
                ->pluck('user_target_id')
                ->toArray();

            if (count($hideLocalPostByAuthor)) {
                $query['hide_author_id'] = $hideLocalPostByAuthor;
            }

            if (count($userBlockingIds)) {
                if (isset($query['hide_author_id'])) {
                    $query['hide_author_id'] = array_merge($userBlockingIds, $query['hide_author_id']);
                } else {
                    $query['hide_author_id'] = $userBlockingIds;
                }
            }
        }

        (new ProductCriteria($query))->apply($productQuery);

        if ($sortBy && $sortType && in_array($sortBy, FiltterProductList::SORT_BY) && in_array(strtolower($sortType), FiltterProductList::SORT_TYPE)) {
            if ($location && ($sortBy == FiltterProductList::SORT_BY[0] || $sortBy == FiltterProductList::SORT_BY[3])) {
                $productQuery->orderBy('distance', $sortType);
            } else {
                if (!($sortBy == FiltterProductList::SORT_BY[0] || $sortBy == FiltterProductList::SORT_BY[3])) {
                    $productQuery->orderBy("products.$sortBy", $sortType);
                }
            }
        } else {
            $productQuery->orderBy("products.created_at", 'DESC');
        }

        return $productQuery->cursorPaginate($limit);
    }
}
