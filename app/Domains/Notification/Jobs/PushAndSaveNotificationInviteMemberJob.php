<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\IntroduceMemberHistories;
use App\Models\User;
use Lucid\Units\Job;
use Throwable;

class PushAndSaveNotificationInviteMemberJob extends Job
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @var User
     */
    protected User $referUser;

    /**
     * @var IntroduceMemberHistories
     */
    protected IntroduceMemberHistories $introduceMemberHistories;

    /**
     * PushAndSaveNotificationInviteMemberJob constructor.
     * @param User $user
     * @param User $referUser
     * @param IntroduceMemberHistories $introduceMemberHistories
     */
    public function __construct(User $user, User $referUser, IntroduceMemberHistories $introduceMemberHistories)
    {
        $this->user                     = $user;
        $this->referUser                = $referUser;
        $this->introduceMemberHistories = $introduceMemberHistories;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $notificationId = $this->saveNotification();
        $this->pushNotification($notificationId);

        return true;
    }

    /**
     * @param $notificationId
     * @return bool
     */
    public function pushNotification($notificationId): bool
    {
        $lang  = $this->referUser->setting?->language ?? 'ko';
        $token = $this->referUser->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.user.invite_member_title');
        $content = trans('messages.notification.user.invite_member_content');
        $actionType = NotificationAction::INVITE_MEMBER;

        if ($this->referUser->cnt_refer == 9) {
            $title   = trans('messages.notification.user.invite_9_member_title');
            $content = trans('messages.notification.user.invite_9_member_content');
            $actionType = NotificationAction::INVITE_9_MEMBER;
        }

        $options = [
            'type' => NotificationType::INVITE_MEMBER,
            'data' => [
                'navigate'                 => NotificationType::NAVIGATE['INVITE_MEMBER_SCREEN'],
                'action_type'              => $actionType,
                'target_id'                => $this->referUser->id,
                'user'                     => $this->user,
                'introduceMemberHistories' => $this->introduceMemberHistories,
                'notification_id'           => $notificationId
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
     * @return bool|int
     */
    public function saveNotification()
    {
        $actionType = NotificationAction::INVITE_MEMBER;
        if ($this->referUser->cnt_refer == 9) {
            $actionType = NotificationAction::INVITE_9_MEMBER;
        }

        $notification = new StoreNotificationJob(
            EntityMorphType::USER,
            $this->user->id,
            $this->user->id,
            $this->referUser->id,
            $actionType,
            EntityMorphType::INTRODUCE_MEMBER_HISTORY,
            $this->introduceMemberHistories->id
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }
}
