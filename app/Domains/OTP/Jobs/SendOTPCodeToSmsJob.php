<?php

namespace App\Domains\OTP\Jobs;

use App\Enum\BusinessExceptionCode;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lucid\Units\QueueableJob;

class SendOTPCodeToSmsJob extends QueueableJob
{
    public function __construct(
        private string $phone,
        private string $message
    ) {
    }

    /**
     * @throws BusinessException
     */
    public function handle()
    {
        $response = Http::asMultipart()
            ->post(config('services.domain.dutta').'/api/notification/sms', [
                'phone'   => $this->phone,
                'message' => $this->message,
            ]);

        if ($response->status() >= 400) {
            Log::error('send_otp_code_fail', [$response->status(), $response->json()]);
            throw new BusinessException(
                __('messages.otp.send_code_fail'),
                BusinessExceptionCode::OTP_SEND_CODE_FAIL
            );
        }
    }
}
