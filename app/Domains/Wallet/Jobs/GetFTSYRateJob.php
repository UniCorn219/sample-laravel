<?php

namespace App\Domains\Wallet\Jobs;

use Illuminate\Support\Facades\Http;
use Lucid\Units\Job;

class GetFTSYRateJob extends Job
{
    public function handle()
    {
        $response = Http::get(config('services.domain.wallet').'/admin/rates/FTSY_POINT')
            ->json();

        return $response['data']['reverse_rate'] ?? 0;
    }
}
