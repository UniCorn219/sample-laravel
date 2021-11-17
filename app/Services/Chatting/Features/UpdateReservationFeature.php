<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\Message\CreateReservationMessageJob;
use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Domains\Chatting\Jobs\UpdateReservationJob;
use App\Domains\Chatting\Jobs\UpdateThreadJob;
use App\Domains\Chatting\Requests\UpdateReservationRequest;
use App\Enum\MessageType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Firestore\Thread;
use App\Services\BaseFeatures;
use App\Services\Notification\Operations\PushNotificationOperation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UpdateReservationFeature extends BaseFeatures
{
    private string $threadId;
    private int    $reservationId;

    /**
     * UpdateReservationFeature constructor.
     */
    public function __construct(string $threadId, int $reservationId)
    {
        $this->threadId      = $threadId;
        $this->reservationId = $reservationId;
    }

    public function handle(UpdateReservationRequest $request)
    {
        $user = Auth::user();
        $this->run(GetThreadInfoJob::class, [
            'threadFuid' => $this->threadId,
        ]);

        $timeRemind      = $request->get('time_remind');
        $timeReservation = $request->get('time_reservation');

        $datetime   = Carbon::createFromFormat('Y-m-d\TH:i:s.vP', $timeReservation);
        $timeRemind = Carbon::createFromFormat('Y-m-d\TH:i:s.vP', $timeRemind);

        $reservation = $this->run(UpdateReservationJob::class, [
            'id'         => $this->reservationId,
            'attributes' => [
                'time_remind'      => $timeRemind->clone()->setTimezone('UTC')->startOfMinute(),
                'time_reservation' => $datetime->clone()->setTimezone('UTC')->startOfMinute(),
            ],
        ]);

        $this->run(CreateReservationMessageJob::class, [
            'user'              => $user,
            'threadFuid'        => $this->threadId,
            'datetime'          => $datetime,
            'timeRemind'        => $timeRemind,
            'reservationStatus' => MessageType::RESERVATION_UPDATED,
            'reservationId'     => $reservation->id,
            'text'              => __('messages.chatting.reservation.update', [
                'user'      => $user->nickname,
                'month'     => $datetime->format('m'),
                'date'      => $datetime->format('d'),
                'time'      => $datetime->format('H:i'),
                'dayOfWeek' => __('messages.date.day_of_week.' . $datetime->format('N')),
            ]),
        ]);

        $threadChat = Thread::query()->find($this->threadId);
        // has three action_type
        $actionType = $this->getActionTypeChatting($threadChat);

        // product if had
        $product = null;

        // get product object when user and user has product
        if ($actionType == NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT) {
            $product = $threadChat->product;
        }

        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $this->threadId,
            'title'             => __('messages.notification.chatting.reservation.title'),
            'content'           => __('messages.notification.chatting.reservation.update', ['nickname' => $user->nickname]),
            'sender'            => $user,
            'isStore'           => false,
            'senderFirebaseUid' => $user->firebase_uid,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => NotificationAction::UPDATE_RESERVATION,
                    'target_id'   => $this->threadId,
                    'sender'      => $user,
                    'isStoreSend' => false,
                    'product'     => $product,
                ]
            ],
            'actionType'        => NotificationAction::UPDATE_RESERVATION
        ]);

        $this->runInQueue(UpdateThreadJob::class, [
            'values' => [
                'reservation' => [
                    'id'          => $reservation->id,
                    'time'        => $datetime,
                    'time_remind' => $timeRemind,
                    'status'      => MessageType::RESERVATION_SUCCESS,
                ],
            ],
            'docId' => $this->threadId,
        ]);

        return $this->responseOk($reservation);
    }

    private function getActionTypeChatting($threadChat): int
    {
        if ($threadChat->has_product) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT;
        }

        return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
    }
}
