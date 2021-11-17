<?php

namespace App\Domains\Point\Jobs;

use Illuminate\Support\Facades\Http;
use Lucid\Units\Job;
use Throwable;

class GetCurrentBalanceTokenJob extends Job
{
    private string $uid;

    /**
     * Create a new job instance.
     *
     * @param  string  $uid
     */
    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): int
    {
        $response = Http::get(config('services.domain.wallet').'/admin/users/'.$this->uid)
            ->json();

        if (empty($response['data']['accounts']) || !is_array($response['data']['accounts'])) {
            return 0;
        }

        $account = collect($response['data']['accounts'])
            ->where('asset', config('payment.asset_token'))
            ->first();

        $response = Http::get(config('services.domain.wallet').'/admin/rates/FTSY_POINT')
            ->json();

        $amount = $account['balance'] ?? 0;
        $rate   = $response['data']['rate'] ?? 0;

        return (int) ($amount * $rate);
    }
}
