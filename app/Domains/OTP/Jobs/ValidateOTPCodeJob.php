<?php

namespace App\Domains\OTP\Jobs;

use App\Enum\BusinessExceptionCode;
use App\Enum\OTPCodeLogStatus;
use App\Exceptions\BusinessException;
use App\Models\OTPCodeLog;
use App\Models\OTPToken;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;
use Throwable;

class ValidateOTPCodeJob extends Job
{
    public function __construct(
        private int $userId,
        private int $type,
        private string $code
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        /** @var OTPToken|null $token */
        $token = OTPToken::where('user_id', $this->userId)
            ->where('type', $this->type)
            ->first();

        throw_if(
            !$token || !Hash::check($this->code, $token->token),
            BusinessException::class,
            __('messages.otp.code_is_invalid'),
            BusinessExceptionCode::OTP_CODE_IS_INVALID
        );

        $expired = $token->updated_at->clone()->addSeconds($token->validity);
        throw_if(
            $expired->isPast(),
            BusinessException::class,
            __('messages.otp.code_has_been_expired'),
            BusinessExceptionCode::OTP_CODE_HAS_BEEN_EXPIRED,
        );

        OTPCodeLog::create([
            'user_id'      => $token->user_id,
            'type'         => $token->type,
            'status'       => OTPCodeLogStatus::VALIDATED,
            'code'         => $this->code,
            'token'        => $token->token,
            'generated_at' => $token->updated_at,
        ]);

        $token->delete();
    }
}
