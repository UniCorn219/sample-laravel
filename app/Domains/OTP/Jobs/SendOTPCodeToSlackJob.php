<?php

namespace App\Domains\OTP\Jobs;

use App\Notifications\SendOTPNotification;
use Illuminate\Support\Facades\Notification;
use Lucid\Units\QueueableJob;

class SendOTPCodeToSlackJob extends QueueableJob
{
    public function __construct(
        private int $userId,
        private string $phone,
        private string $nickname,
        private string $message,
        private string $prefix
    ) {
    }

    public function handle()
    {
        $content = '[' . $this->prefix . ']'
            . ' UserId: ' . $this->userId
            . '. Nickname: ' . $this->nickname
            . '. Phone: ' . $this->phone
            . '. Message: ' . $this->message;

        Notification::route('slack', config('services.slack.otp_webhook_url'))
            ->notify(new SendOTPNotification($content));
    }
}
