<?php

namespace App\Domains\Product\Jobs;

use App\Enum\BusinessExceptionCode;
use App\Exceptions\BalanceNotEnough;
use App\Exceptions\BusinessException;
use App\ValueObjects\Amount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Job;
use Throwable;

class CreateSafePaymentJob extends Job
{
    public function __construct(
        private string $sellerUid,
        private string $buyerUid,
        private Amount $amount,
    )
    {}

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle()
    {
        $response = Http::post(config('services.domain.wallet').'/internal/transactions', [
            'creditor'         => $this->sellerUid,
            'debtor'           => $this->buyerUid,
            'transaction_type' => 'safe_payment',
            'currency'         => 'FTSY',
            'amount'           => $this->amount->amount(),
            'is_escrow'        => true,
        ]);

        $data = $response->json();

        throw_if(
            isset($data['error']['type']) && $data['error']['type'] == 'insufficient_balance_error',
            BalanceNotEnough::class,
            __('messages.payment.balance_ftsy_not_enough'),
            BusinessExceptionCode::BALANCE_NOT_ENOUGH
        );

        if ($response->status() >= 400 || empty($data['data']['txid'])) {
            Log::error('create_safe_payment_fail', [$response->status(), $response->json()]);
            throw new BusinessException(
                __('messages.payment.create_safe_payment_fail'),
                BusinessExceptionCode::CREATE_SAFE_PAYMENT_FAIL
            );
        }

        return $response->json();
    }
}
