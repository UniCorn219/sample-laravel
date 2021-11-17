<?php

namespace App\Domains\OTP\Jobs;

use App\Models\OTPCodeLog;
use Illuminate\Support\Carbon;
use Lucid\Units\Job;

class CreateOTPCodeLogJob extends Job
{
    public function __construct(
        private int $userId,
        private int $type,
        private int $status,
        private ?string $code,
        private string $token,
        private Carbon $generatedAt
    ) {
    }

    public function handle()
    {
        OTPCodeLog::create([
            'user_id'      => $this->userId,
            'type'         => $this->type,
            'status'       => $this->status,
            'code'         => $this->code,
            'token'        => $this->token,
            'generated_at' => $this->generatedAt,
        ]);
    }
}
