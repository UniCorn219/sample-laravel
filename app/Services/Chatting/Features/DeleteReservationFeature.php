<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\Message\CreateReservationMessageJob;
use App\Domains\Chatting\Jobs\UpdateThreadJob;
use App\Enum\MessageType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Firestore\Thread;
use App\Models\Reservation;
use App\Services\BaseFeatures;
use App\Services\Notification\Operations\PushNotificationOperation;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Feature;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteReservationFeature extends BaseFeatures
{
    private $param;

    /**
     * DeleteReservationFeature constructor.
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    public function handle(Request $request)
    {
        $user = Auth::user();
        $thread = Thread::find($this->param['id']);

        if (!$thread) {
            throw new NotFoundHttpException();
        }

        Reservation::query()->findOrFail($this->param['reserId']);
        Reservation::query()
            ->where('id', $this->param['reserId'])->delete();

        $this->run(CreateReservationMessageJob::class, [
            'user'              => $user,
            'threadFuid'        => $this->param['id'],
            'reservationStatus' => MessageType::RESERVATION_CANCELED,
            'text' =>  __('messages.chatting.reservation.delete'),
        ]);



        $threadChat = Thread::query()->find($thread->id);
        // has three action_type
        $actionType = $this->getActionTypeChatting($threadChat);

        // product if had
        $product = null;

        // get product object when user and user has product
        if ($actionType == NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT) {
            $product = $threadChat->product;
        }

        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $thread->id,
            'title'             => __('messages.notification.chatting.reservation.title'),
            'content'           => __('messages.notification.chatting.reservation.delete', ['nickname' => $user->nickname]),
            'sender'            => $user,
            'isStore'           => false,
            'senderFirebaseUid' => $user->firebase_uid,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => NotificationAction::DELETE_RESERVATION,
                    'target_id'   => $thread->id,
                    'sender'      => $user,
                    'isStoreSend' => false,
                    'product'     => $product,
                ]
            ],
            'actionType'        => NotificationAction::DELETE_RESERVATION
        ]);

        $this->runInQueue(UpdateThreadJob::class, [
            'values' => [
                'reservation' => null,
            ],
            'docId' => $thread->id,
        ]);

        return $this->responseOk();
    }

    private function getActionTypeChatting($threadChat): int
    {
        if ($threadChat->has_product) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT;
        }

        return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
    }
}
