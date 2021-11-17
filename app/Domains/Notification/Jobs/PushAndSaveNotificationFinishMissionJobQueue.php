<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Mission;
use App\Models\User;
use App\Models\UserMission;
use Lucid\Units\QueueableJob;
use Throwable;

class PushAndSaveNotificationFinishMissionJobQueue extends QueueableJob
{
    protected UserMission $userMission;

    /**
     * PushAndSaveNotificationMissionJobNonQueue constructor.
     * @param UserMission $userMission
     */
    public function __construct(UserMission $userMission)
    {
        $this->userMission = $userMission;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $user    = User::find($this->userMission->user_id);
        $mission = Mission::find($this->userMission->mission_id);

        $notificationId = $this->saveNotification($user, $mission);
        $this->pushNotification($user, $mission, $notificationId);

        return true;
    }

    /**
     * @param $user
     * @param $mission
     * @param $notificationId
     * @return bool
     */
    public function pushNotification($user, $mission, $notificationId): bool
    {
        $lang  = $user->setting?->language ?? 'ko';
        $token = $user->token_fcm;

        app()->setLocale($lang);

        $title   = __('messages.notification.mission.title');
        $content = __('messages.notification.mission.content');

        $options = [
            'type' => NotificationType::MISSION,
            'data' => [
                'navigate'    => NotificationType::NAVIGATE['MISSION_SCREEN'],
                'action_type' => NotificationAction::DONE_MISSION,
                'target_id'   => $user->id,
                'mission'     => $mission,
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
     * @param $user
     * @param $mission
     * @return bool|int
     */
    public function saveNotification($user, $mission)
    {
        $notification = new StoreNotificationJob(
            EntityMorphType::USER,
            $user->id,
            $user->id,
            $user->id,
            NotificationAction::DONE_MISSION,
            EntityMorphType::MISSION,
            $mission->id
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }
}
