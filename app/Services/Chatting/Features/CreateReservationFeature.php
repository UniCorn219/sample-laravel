<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\CreateUniqueOrUpdateReservationJob;
use App\Domains\Chatting\Jobs\Message\CreateReservationMessageJob;
use App\Domains\Chatting\Jobs\UpdateThreadJob;
use App\Domains\Chatting\Requests\CreateReservationRequest;
use App\Enum\MessageType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Firestore\Thread;
use App\Models\Reservation;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use App\Services\Notification\Operations\PushNotificationOperation;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateReservationFeature extends BaseFeatures
{
    /**
     * @var int id
     */
    private string $id;

    /**
     * CreateReservationFeature constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function handle(CreateReservationRequest $request)
    {
        $user   = Auth::user();
        $thread = Thread::find($this->id);

        if (empty($thread)) {
            throw new NotFoundHttpException();
        }

        $thread = $thread->toArray();

        $participants = Arr::get($thread, 'participants', []);

        $param = [
            'thread_id'        => $this->id,
            'product_id'       => Arr::get($thread, 'product.id', null),
            'buyer_id'         => $participants[0]['id'],
            'seller_id'        => $participants[1]['id'],
            'time_remind'      => $request->time_remind,
            'time_reservation' => $request->time_reservation,
            'status'           => Reservation::STATUS_CONFIRMED
        ];

        $datetime   = Carbon::createFromFormat('Y-m-d\TH:i:s.vP', $request->time_reservation);
        $timeRemind = Carbon::createFromFormat('Y-m-d\TH:i:s.vP', $request->time_remind);

        $param['time_reservation'] = $datetime->clone()->setTimezone('UTC')->startOfMinute();
        $param['time_remind']      = $timeRemind->clone()->setTimezone('UTC')->startOfMinute();

        $reservation = $this->run(CreateUniqueOrUpdateReservationJob::class, ['param' => $param]);

        $result = $this->run(CreateReservationMessageJob::class, [
            'user'              => $user,
            'threadFuid'        => $this->id,
            'reservationId'     => $reservation->id,
            'datetime'          => $datetime,
            'timeRemind'        => $timeRemind,
            'reservationStatus' => $reservation->wasRecentlyCreated ? MessageType::RESERVATION_SUCCESS : MessageType::RESERVATION_UPDATED,
            'text'              => __('messages.chatting.reservation.create', [
                'date' => $datetime->format('Y.m.d'),
                'time' => $datetime->format('H:i'),
                'noon' => __('messages.date.noon.' . $datetime->format('a'))
            ]),
        ]);

        $this->runInQueue(UpdateLatestMessageOperation::class, [
            'threadFuid'          => $this->id,
            'userFuid'            => $user->firebase_uid,
            'lastMessageSender'   => __('messages.notification.chatting.reservation.message_thread_create'),
            'lastMessageReceiver' => __('messages.notification.chatting.reservation.message_thread_create'),
            'result'              => $result,
        ]);

        $threadChat = Thread::query()->find($this->id);
        // has three action_type
        $actionType = $this->getActionTypeChatting($threadChat);

        // product if had
        $product = null;

        // get product object when user and user has product
        if ($actionType == NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT) {
            $product = $threadChat->product;
        }

        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $this->id,
            'title'             => __('messages.notification.chatting.reservation.title'),
            'content'           => __('messages.notification.chatting.reservation.create', ['nickname' => $user->nickname]),
            'sender'            => $user,
            'isStore'           => false,
            'senderFirebaseUid' => $user->firebase_uid,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => NotificationAction::CREATE_RESERVATION,
                    'target_id'   => $this->id,
                    'sender'      => $user,
                    'isStoreSend' => false,
                    'product'     => $product,
                ]
            ],
            'actionType'        => NotificationAction::CREATE_RESERVATION
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
            'docId'  => $this->id,
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
