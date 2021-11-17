<?php

namespace App\Domains\Product\Jobs;

use App\Criteria\ProductCriteria;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetListProductHiddenOfUserJob extends Job
{
    protected array $query;

    /**
     * Create a new job instance.
     *
     * @param array $query
     */
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * Execute the job.
     */
    public function handle(): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $query = $this->query;
        $limit = $query['limit'] ?? 10;
        $limit = min($limit, 50);

        $distance            = $query['distance'] ?? null;
        $location            = $query['location'] ?? null;
        $locationSelectQuery = DB::raw("concat_ws(',', ST_Y(location::geometry),ST_X(location::geometry)) as location");

        $productQuery = Product::with('owner.address', 'images', 'category')
            ->select(['*'])
            ->addSelect($locationSelectQuery);

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
