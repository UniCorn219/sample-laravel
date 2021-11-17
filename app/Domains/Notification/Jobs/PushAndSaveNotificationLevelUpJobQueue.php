<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\User;
use Lucid\Units\QueueableJob;
use Throwable;

class PushAndSaveNotificationLevelUpJobQueue extends QueueableJob
{
    protected User $user;

    /**
     * PushAndSaveNotificationMissionJobNonQueue constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $this->pushAndSaveNotification($this->user);

        return true;
    }

    /**
     * @param $user
     * @return bool
     */
    protected function pushAndSaveNotification($user): bool
    {
        $notificationId = $this->saveNotification($user->id, $user->id);
        $this->pushNotification($user, $notificationId);

        return true;
    }

    /**
     * @param $user
     * @return bool
     */
    public function pushNotification($user, $notificationId): bool
    {
        if (!$notificationId) {
            return false;
        }
        $lang  = $user->setting?->language ?? 'ko';
        $token = $user->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.user.level_up_title');
        $content = trans('messages.notification.user.level_up_content');

        $options = [
            'type' => NotificationType::BATTERY,
            'data' => [
                'navigate'    => NotificationType::NAVIGATE['USER_PROFILE_SCREEN'],
                'action_type' => NotificationAction::BATTERY_LEVEL_UP,
                'target_id'   => $user->id,
                'notification_id' => $notificationId
            ]
        ];

        $pushNotification = new PushNotificationJobNonQueue($token, $content, $title, $options);

        try {
            $pushNotification->handle();

            return true;
        } catch (Throwable) {
            return true;
        }
    }

    /**
     * @param $userId
     * @param $userTargetId
     * @return bool|int
     */
    public function saveNotification($userId, $userTargetId)
    {
        $notification = new StoreNotificationJob(
            EntityMorphType::USER,
            $userTargetId,
            $userId,
            $userTargetId,
            NotificationAction::BATTERY_LEVEL_UP,
            EntityMorphType::USER,
            $userId
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }
}
