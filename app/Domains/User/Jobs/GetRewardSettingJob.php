<?php

namespace App\Domains\User\Jobs;

use Illuminate\Support\Facades\Http;
use Lucid\Units\Job;
use Throwable;

class GetRewardSettingJob extends Job
{
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle()
    {
        $response = Http::get(config('services.domain.dutta') . '/api/master/setting_reward');

        if ($response->status() != 200) {
            return [];
        }

        return $response->json()['data'];
    }
}
