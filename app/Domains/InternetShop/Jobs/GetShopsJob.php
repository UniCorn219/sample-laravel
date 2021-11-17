<?php

namespace App\Domains\InternetShop\Jobs;

use App\Models\InternetShop;
use Lucid\Units\Job;
use Illuminate\Support\Facades\DB;
use App\Enum\InternetShopStatus;
use Illuminate\Support\Facades\Auth;

class GetShopsJob extends Job
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
        $internetShopsQuery =  InternetShop::select([
            'id',
            'name',
            'banner_path',
            'description',
            'url',
            'total_click',
            'total_like',
            'total_dislike',
            'link_share',
            'created_at'
        ])
            ->withCount([
                'reviews AS total_star' => function ($query) {
                    $query->select(DB::raw("SUM(star_number)"));
                }
            ])
            ->withCount('reviews');
        if (!empty(Auth::user())) {
            $internetShopsQuery->withCount([
                'reviews AS has_evaluated' => function ($query) {
                    $query->where('user_id', '=', Auth::user()->id);
                }
            ]);
        }
        return $internetShopsQuery->where('status', '=', InternetShopStatus::STATUS_ON)
            ->orderBy('order')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
    }
}
