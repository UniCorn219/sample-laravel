<?php

namespace App\Domains\InternetShop\Jobs;

use App\Models\InternetShopReview;
use Lucid\Units\Job;
use App\Enum\ReviewInternetShopSortBy;

class GetListReviewsShopJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @var array $param
     */
    private array $params;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        $limit = $this->params['limit'];
        $query = InternetShopReview::select(['id', 'user_id', 'star_number', 'content','created_at', 'updated_at'])
            ->where('internet_shop_id', '=', $this->params['internet_shop_id'])
            ->with('user', function ($query) {
                $query->select(['id','name', 'nickname', 'avatar']);
            });
        switch ($this->params['sort_by']) {
            case ReviewInternetShopSortBy::HIGHEST :
                $query->orderByDesc('star_number');
                break;
            case ReviewInternetShopSortBy::LOWEST :
                $query->orderBy('star_number');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }
        return $query->cursorPaginate($limit);
    }
}