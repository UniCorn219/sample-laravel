<?php

namespace App\Domains\InternetShop\Jobs;

use App\Models\InternetShop;
use Lucid\Units\Job;


class IncreaseViewShopJob extends Job
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
        return $internetShop->update(['total_click' => $internetShop->total_click + 1]);
    }
}