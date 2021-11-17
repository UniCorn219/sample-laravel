<?php

namespace App\Domains\Wallet\Jobs;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Job;

class CancelPaymentJob extends Job
{
    public function __construct(
        private string $txid
    ) {
    }

    /**
     * @return mixed
     * @throws BusinessException
     */
    public function handle(): mixed
    {
        $response = Http::delete(config('services.domain.wallet').'/internal/transactions/'.$this->txid);

        if ($response->status() >= 400) {
            Log::error('cancel_wallet_payment_fail', [$response->status(), $response->json()]);
            throw new BusinessException(__('messages.payment.cancel_wallet_payment_fail'));
        }

        return $response->json();
    }
}
