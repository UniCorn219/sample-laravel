<?php

namespace App\Domains\InternetShop\Jobs;

use App\Models\InternetShop;
use Lucid\Units\Job;
use Illuminate\Support\Facades\DB;
use App\Enum\InternetShopStatus;

class GetOverviewReviewShopJob extends Job
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
        $internetShop =  InternetShop::select(['id', 'name', 'banner_path', 'description', 'url', 'created_at'])
            ->withCount([
                'reviews AS total_star' => function ($query) {
                    $query->select(DB::raw("SUM(star_number)"));
                }
            ])
            ->withCount('reviews');
        for ($star=1; $star<=5; $star++) {
            $internetShop->withCount([
                'reviews AS total_user_review_'. $star .'_star' => function ($query) use ($star) {
                    $query->select(DB::raw("COUNT(id)"))->where('star_number', '=', $star);
                }
            ]);
        }
        return $internetShop->where('status', '=', InternetShopStatus::STATUS_ON)
            ->findOrFail($this->params['internet_shop_id']);
    }
}