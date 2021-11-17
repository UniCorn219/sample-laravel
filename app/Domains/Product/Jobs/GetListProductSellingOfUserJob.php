<?php

namespace App\Domains\Product\Jobs;

use App\Criteria\ProductCriteria;
use App\Enum\UserHidingType;
use App\Models\Product;
use App\Models\UserBlocking;
use App\Models\UserHiding;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetListProductSellingOfUserJob extends Job
{
    protected array $query;
    protected int   $authId;

    /**
     * @param array $query
     * @param int   $authId
     */
    public function __construct(array $query, int $authId)
    {
        $this->query  = $query;
        $this->authId = $authId;
    }

    /**
     * Execute the job.
     */
    public function handle(): CursorPaginator
    {
        $query = $this->query;
        $limit = $query['limit'] ?? 10;
        $limit = min($limit, 50);

        $distance            = $query['distance'] ?? null;
        $location            = $query['location'] ?? null;
        $locationSelectQuery = DB::raw("concat_ws(',', ST_Y(location::geometry),ST_X(location::geometry)) as location");

        $productQuery = Product::with('owner.address', 'images', 'category', 'reviewed')
            ->select(['*'])
            ->addSelect($locationSelectQuery);

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

        if ($distance && $location) {
            // $location should be long lat
            $productQuery->addSelect(DB::raw('ST_Distance(location, ref_geom) AS distance'))
                ->crossJoinSub("SELECT ST_MakePoint($location)::geography AS ref_geom", 'temporary')
                ->whereRaw("ST_DWithin(location, ref_geom, $distance)")
                ->orderBy('distance');
        } else {
            $productQuery->orderBy('id', 'DESC');
        }

        return $productQuery->cursorPaginate($limit);
    }
}
