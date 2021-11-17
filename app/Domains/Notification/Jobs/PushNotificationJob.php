<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\NotificationType;
use App\Models\User;
use App\Services\FCM\FCMService;
use Carbon\Carbon;
use LaravelFCM\Message\Exceptions\InvalidOptionsException;
use Lucid\Units\QueueableJob;

class PushNotificationJob extends QueueableJob
{
    private string $tokenFcm;
    private string $content;
    private string $title;
    private array  $options;
    private bool   $isPushImage;

    /**
     * PushNotificationJob constructor.
     * @param string $tokenFcm
     * @param string $content
     * @param string $title
     * @param array $options
     * @param false $isPushImage
     */
    public function __construct(string $tokenFcm, string $content, string $title, array $options = [], $isPushImage = false)
    {
        $this->tokenFcm    = $tokenFcm;
        $this->content     = $content;
        $this->title       = $title;
        $this->options     = $options;
        $this->isPushImage = $isPushImage;
    }

    /**
     * @return mixed
     * @throws InvalidOptionsException
     */
    public function handle(): mixed
    {
        if (!$this->canPushNotificationToUser()) {
            return null;
        }

        if ($this->isPushImage) {
            return resolve(FCMService::class)->sendBySingleTokenHaveImage(
                $this->tokenFcm,
                $this->content,
                $this->title,
                $this->options['data'] ?? [],
                $this->options['data']['image'] ?? ''
            );
        }

        return resolve(FCMService::class)->sendBySingleToken(
            $this->tokenFcm,
            $this->content,
            $this->title,
            $this->options['data'] ?? []
        );
    }

    /**
     * @return bool
     */
    public function canPushNotificationToUser(): bool
    {
        $userDetail = User::with('setting')->where('token_fcm', $this->tokenFcm)->first();

        if ($userDetail && $userDetail->setting && $userDetail->setting->disturb_setting) {
            $userSetting = $userDetail->setting;
            $startTime   = $userSetting->disturb_start_time;
            $endTime     = $userSetting->disturb_end_time;

            $now   = Carbon::now();
            $start = Carbon::createFromTimeString($startTime);
            $end   = Carbon::createFromTimeString($endTime)->addDay();

            if ($now->between($start, $end)) {
                return false;
            }
        }

        if ($userDetail && $userDetail->setting) {
            $userSetting = $userDetail->setting;
            if (isset($this->options['type'])) {
                return match ($this->options['type']) {
                    NotificationType::CHAT => $userSetting->chat_alert,
                    NotificationType::KEYWORD => $userSetting->keyword_alert,
                    NotificationType::ACTIVITY => $userSetting->activity_alert,
                    NotificationType::TRANSACTION => $userSetting->transaction_alert,
                    NotificationType::MARKETING => $userSetting->marketing_alert,
                    default => true,
                };
            }
        }

        return true;
    }
}
