<?php

namespace App\Domains\OTP\Jobs;

use App\Models\OTPToken;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class GetOTPTokenJob extends Job
{
    public function __construct(
        private int $userId,
        private int $type
    ) {
    }

    public function handle(): Model|OTPToken|null
    {
        return OTPToken::where('user_id', $this->userId)
            ->where('type', $this->type)
            ->first();
    }
}
