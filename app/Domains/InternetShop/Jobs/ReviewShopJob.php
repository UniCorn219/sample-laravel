<?php

namespace App\Domains\InternetShop\Jobs;

use App\Models\InternetShop;
use Lucid\Units\Job;
use Illuminate\Validation\ValidationException;


class ReviewShopJob extends Job
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
        $internetShop = InternetShop::query()->findOrFail($this->params['id']);
        if ($internetShop->reviews()->where('user_id', $this->params['data']['user_id'])->count() > 0) {
            throw ValidationException::withMessages([__('messages.internet_shop.review_exists')]);
        }
        return $internetShop->reviews()->create($this->params['data']);
    }
}