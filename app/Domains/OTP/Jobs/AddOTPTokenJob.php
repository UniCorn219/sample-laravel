<?php

namespace App\Domains\OTP\Jobs;

use App\Models\OTPToken;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;

class AddOTPTokenJob extends Job
{
    public function __construct(
        private int $userId,
        private string $code,
        private int $type,
        private int $validity
    ) {
    }

    public function handle()
    {
        OTPToken::upsert(
            [
                'user_id'  => $this->userId,
                'token'    => Hash::make($this->code),
                'type'     => $this->type,
                'validity' => $this->validity,
            ],
            ['user_id', 'type'],
            ['token']
        );
    }
}
