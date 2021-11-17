<?php

namespace App\Domains\Store\Jobs;

use App\Exceptions\BusinessException;
use App\Models\MenuStore;
use Lucid\Units\Job;
use Throwable;

class ValidateMainMenuJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $count = MenuStore::where('store_id', $this->id)
            ->where('is_main', true)
            ->count();

        throw_if(
            $count >= config('constant.max_store_main_menu'),
            BusinessException::class,
            __('messages.max_store_main_menu')
        );
    }
}
