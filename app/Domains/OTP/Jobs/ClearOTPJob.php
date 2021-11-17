<?php

namespace App\Domains\OTP\Jobs;

use App\Enum\OTPCodeLogStatus;
use App\Models\OTPCodeLog;
use App\Models\OTPToken;
use Illuminate\Support\Carbon;
use Lucid\Units\Job;

class ClearOTPJob extends Job
{
    public function handle()
    {
        $otps = OTPToken::whereRaw("updated_at + validity * interval '1 second' < now()")
            ->get();

        if ($otps->isEmpty()) {
            return;
        }

        $now  = Carbon::now();
        $logs = $otps->map(function (OTPToken $token) use ($now) {
            return [
                'user_id'      => $token->user_id,
                'type'         => $token->type,
                'status'       => OTPCodeLogStatus::EXPIRED,
                'code'         => null,
                'token'        => $token->token,
                'generated_at' => $token->updated_at,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        })
            ->toArray();

        OTPCodeLog::insert($logs);

        OTPToken::whereIn('id', $otps->pluck('id'))->delete();
    }
}
