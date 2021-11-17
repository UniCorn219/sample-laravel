<?php

namespace App\Domains\TransactionLog\Jobs;

use App\Models\TransactionLog;
use App\ValueObjects\Amount;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreateTransactionLogJob extends Job
{
    public function __construct(
        private int $transactionId,
        private int $transactionStatus,
        private int $userId,
        private Amount $amount,
        private int $amountType,
        private mixed $amountRate,
        private ?int $actorId = null,
        private ?string $actorType = null,
        private ?string $payload = null,
    ) {
    }

    public function handle(): Model|TransactionLog
    {
        return TransactionLog::create([
            'transaction_id'     => $this->transactionId,
            'transaction_status' => $this->transactionStatus,
            'user_id'            => $this->userId,
            'amount'             => $this->amount,
            'amount_type'        => $this->amountType,
            'amount_rate'        => $this->amountRate,
            'actor_id'           => $this->actorId,
            'actor_type'         => $this->actorType,
            'payload'            => $this->payload,
        ]);
    }
}
