<?php

namespace App\Services\Chatting\Traits;

use App\Enum\MessageType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Firestore\Message;
use App\Models\Store;
use App\Services\Chatting\Operations\MarkUserRepliedOperation;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use App\Services\Chatting\Operations\UpdateStoreLatestMessageOperation;
use App\Services\Notification\Operations\PushNotificationOperation;
use App\ValueObjects\Amount;
use Illuminate\Support\Facades\Auth;

trait BackgroundOperationTrait
{
    private function getSender()
    {
        $user = Auth::user();

        if ($this->isStore) {
            return Store::query()->where([
                'owner_id' => $user->id,
                'id'       => $this->storeId,
            ])->firstOrFail();
        }

        return $user;
    }

    /**
     * @param string $lastMessageSender
     * @param string $lastMessageReceiver
     * @param string $type
     * @param Message $result
     * @param Amount|null $amount
     * @param string $moneyAmount
     */
    private function backgroundOperationHandler(string $lastMessageSender, string $lastMessageReceiver, string $type, Message $result, Amount $amount = null, $moneyAmount = '')
    {
        $sender = $this->getSender();

        $title = trans('messages.notification.nickname', ['nickname' => $sender->nickname]);

        $contentPush = match ($type) {
            MessageType::TEXT => __('messages.notification.chatting.text.content', ['nickname' => $sender->nickname]),
            MessageType::IMAGE => __('messages.notification.chatting.image.content', ['nickname' => $sender->nickname]),
            MessageType::STICKER => __('messages.notification.chatting.sticker.content', ['nickname' => $sender->nickname]),
            MessageType::LOCATION => __('messages.notification.chatting.location.content', ['nickname' => $sender->nickname]),
            MessageType::SHIPPING_ADDRESS => __('messages.notification.chatting.shipping_address.content', ['nickname' => $sender->nickname]),
            MessageType::BANK_ACCOUNT => __('messages.notification.chatting.bank_accounts.content', ['nickname' => $sender->nickname]),
            MessageType::USER_PAYED => __('messages.notification.chatting.user_payed.content', [
                'nickname'      => $sender->nickname,
                'fantasyAmount' => $amount->amount(),
                'moneyAmount'   => $moneyAmount,
            ]),
            MessageType::SELLER_APPROVE_PAYMENT => __('messages.notification.chatting.user_payed.approve_payment', ['nickname' => $sender->nickname]),
            MessageType::SELLER_REJECT_PAYMENT => __('messages.notification.chatting.user_payed.reject_payment', ['nickname' => $sender->nickname]),
            MessageType::ORDER_RECEIVED => __('messages.notification.chatting.order_received.content', ['nickname' => $sender->nickname]),
            MessageType::USER_CANCEL_PAYMENT => __('messages.notification.chatting.user_cancel_payment.content', ['nickname' => $sender->nickname]),
            MessageType::SHIPPING_COMPANY => __('messages.notification.chatting.shipping_company.content', ['nickname' => $sender->nickname]),
            MessageType::REVIEW => __('messages.notification.chatting.review.content', ['nickname' => $sender->nickname]),
        };

        $this->pushNotification($title, $contentPush, $type);
        $this->updateLatestMessage($lastMessageSender, $lastMessageReceiver, $result);
        $this->markUserReplied();
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $typeChat
     * @throws ReflectionException
     */
    private function pushNotification(string $title, string $content, string $typeChat)
    {
        $sender = $this->getSender();

        // has three action_type
        $actionType = $this->getActionTypeChatting();
        // product if had
        $product = null;

        // get product object when user and user has product
        if ($actionType == NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT) {
            $product = $this->thread->product;
        }

        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $this->threadFuid,
            'title'             => $title,
            'content'           => $content,
            'sender'            => $sender,
            'senderFirebaseUid' => $sender->firebase_uid,
            'isStore'           => $this->isStore,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => $actionType,
                    'target_id'   => $this->threadFuid,
                    'sender'      => $sender,
                    'isStoreSend' => $this->isStore,
                    'product'     => $product,
                    'type_chat'   => $typeChat,
                ]
            ],
            'actionType'        => $actionType
        ]);
    }

    private function getActionTypeChatting(): int
    {
        if ($this->thread->has_product) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT;
        }

        if ($this->isStore) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_STORE;
        }

        if (is_array($this->thread->participants)) {
            foreach ($this->thread->participants as $participant) {
                if (isset($participant['store'])) {
                    return NotificationAction::CREATE_MESSAGE_IN_USER_AND_STORE;
                }
            }

            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
        }

        return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
    }

    /**
     * @param string $lastMessageSender
     * @param string $lastMessageReceiver
     * @param Message $result
     * @throws ReflectionException
     */
    private function updateLatestMessage(string $lastMessageSender, string $lastMessageReceiver, Message $result)
    {
        $sender = $this->getSender();

        if ($this->isStore) {
            $this->runInQueue(UpdateStoreLatestMessageOperation::class, [
                'threadFuid'          => $this->threadFuid,
                'storeFuid'           => $sender->firebase_uid,
                'lastMessageSender'   => $lastMessageSender,
                'lastMessageReceiver' => $lastMessageReceiver,
                'result'              => $result,
            ]);
        } else {
            $this->runInQueue(UpdateLatestMessageOperation::class, [
                'threadFuid'          => $this->threadFuid,
                'userFuid'            => $sender->firebase_uid,
                'lastMessageSender'   => $lastMessageSender,
                'lastMessageReceiver' => $lastMessageReceiver,
                'result'              => $result,
            ]);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function markUserReplied()
    {
        $user = Auth::user();

        $this->runInQueue(MarkUserRepliedOperation::class, [
            'userId'   => $user->id,
            'threadId' => $this->threadFuid,
        ]);
    }
}
