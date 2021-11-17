<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Requests\CreateMessageRequest;
use App\Enum\MessageType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Exceptions\ThreadDoesNotBelongToUserException;
use App\Models\Firestore\Message;
use App\Models\Firestore\Thread;
use App\Models\Store;
use App\Models\UserBankAccount;
use App\Models\UserDeliveryAddress;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\CreateBankAccountMessageOperation;
use App\Services\Chatting\Operations\CreateImageOperation;
use App\Services\Chatting\Operations\CreateLocationMessageOperation;
use App\Services\Chatting\Operations\CreateShippingAddressMessageOperation;
use App\Services\Chatting\Operations\CreateShippingCompanyMessageOperation;
use App\Services\Chatting\Operations\CreateStickerOperation;
use App\Services\Chatting\Operations\CreateTextMessageOperation;
use App\Services\Chatting\Operations\IsThreadBelongToUserOperation;
use App\Services\Chatting\Operations\MarkUserRepliedOperation;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use App\Services\Chatting\Operations\UpdateStoreLatestMessageOperation;
use App\Services\Notification\Operations\PushNotificationOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use ReflectionException;
use Throwable;

class CreateMessageFeature extends BaseFeatures
{
    private bool        $isStore;
    private string      $threadFuid;
    private int|null    $storeId;
    private string      $messageId;
    private object|null $thread;

    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
        $this->thread     = Thread::query()->find($this->threadFuid);
    }

    /**
     * @throws Throwable
     */
    public function handle(CreateMessageRequest $request): JsonResponse
    {
        $start           = microtime(true);
        $type            = $request->get('type');
        $text            = $request->get('text');
        $this->messageId = $request->get('id');
        $this->isStore   = (bool)$request->get('is_store', false);
        $this->storeId   = $request->get('store_id', null);

//        $this->canCreateMessage();

        [$result, $lastMessageSender, $lastMessageReceiver] = match ($type) {
            MessageType::TEXT             => $this->createTextMessage($text),
            MessageType::IMAGE            => $this->createImageMessage($request->file('attachment')),
            MessageType::STICKER          => $this->createStickerMessage($request->get('sticker')),
            MessageType::LOCATION         => $this->createLocationMessage($request->get('location')),
            MessageType::SHIPPING_ADDRESS => $this->createShippingAddressMessage($request->get('shipping_address_id')),
            MessageType::BANK_ACCOUNT     => $this->createBankAccountMessage($request->get('bank_account_id')),
            MessageType::SHIPPING_COMPANY => $this->createShippingCompanyMessage($request->get('shipping_company')),
        };

        $this->backgroundOperationHandler($lastMessageSender, $lastMessageReceiver, $type, $result);
        $timeElapsedSecs = microtime(true) - $start;

        return $this->responseOk([
            'message' => $result,
            'time'    => $timeElapsedSecs,
        ]);
    }

    /**
     * Threads must be belongs to user.
     * @throws Throwable
     */
    private function canCreateMessage()
    {
        // TODO: Write rule in firestore
        $sender               = $this->getSender();
        $isThreadBelongToUser = $this->run(IsThreadBelongToUserOperation::class, [
            'operatorFuid' => $sender->firebase_uid,
            'threadFuid'   => $this->threadFuid,
        ]);

        throw_if(!$isThreadBelongToUser, ThreadDoesNotBelongToUserException::class);
    }


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

    private function createTextMessage($text): array
    {
        $sender  = $this->getSender();
        $message = $this->run(CreateTextMessageOperation::class, [
            'sender'     => $sender,
            'threadFuid' => $this->threadFuid,
            'text'       => $text,
            'id'         => $this->messageId,
        ]);

        $lastMessageSender   = $text;
        $lastMessageReceiver = $text;

        return [$message, $lastMessageSender, $lastMessageReceiver];
    }

    private function createStickerMessage($sticker)
    {
        $sender              = $this->getSender();
        $lastMessageReceiver = __('messages.notification.chatting.sticker.last_message_receiver', ['nickname' => $sender->nickname]);
        $lastMessageSender   = __('messages.notification.chatting.sticker.last_message_sender');

        $messageId = $this->run(CreateStickerOperation::class, [
            'sender'     => $sender,
            'threadFuid' => $this->threadFuid,
            'sticker'    => $sticker,
            'id'         => $this->messageId,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    private function createImageMessage(UploadedFile $file): array
    {
        $sender              = $this->getSender();
        $lastMessageReceiver = __('messages.notification.chatting.image.last_message_receiver', ['nickname' => $sender->nickname]);
        $lastMessageSender   = __('messages.notification.chatting.image.last_message_sender');

        $messageId = $this->run(CreateImageOperation::class, [
            'sender'     => $sender,
            'threadFuid' => $this->threadFuid,
            'image'      => $file,
            'id'         => $this->messageId,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    private function createLocationMessage($location): array
    {
        $sender              = $this->getSender();
        $lastMessageReceiver = __('messages.notification.chatting.location.last_message_receiver', ['nickname' => $sender->nickname]);
        $lastMessageSender   = __('messages.notification.chatting.location.last_message_sender');

        $messageId = $this->run(CreateLocationMessageOperation::class, [
            'sender'     => $sender,
            'threadFuid' => $this->threadFuid,
            'location'   => $location,
            'id'         => $this->messageId,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    private function createShippingAddressMessage($shippingAddressId): array
    {
        $sender = $this->getSender();

        // Check address is exist
        $address = UserDeliveryAddress::query()->where([
            'user_id' => Auth::user()->id,
            'id'      => $shippingAddressId,
        ])->firstOrFail();

        $content = __('messages.notification.chatting.shipping_address.content', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $lastMessageReceiver = __('messages.notification.chatting.shipping_address.last_message_receiver', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);
        $lastMessageSender   = __('messages.notification.chatting.shipping_address.last_message_sender');

        $messageId = $this->run(CreateShippingAddressMessageOperation::class, [
            'sender'     => $sender,
            'threadFuid' => $this->threadFuid,
            'text'       => $content,
            'id'         => $this->messageId,
            'address'    => $address,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    private function createBankAccountMessage($bankAccountId): array
    {
        $sender = $this->getSender();

        // Check bank account is exist
        $bankAccount = UserBankAccount::query()->where([
            'user_id' => Auth::user()->id,
            'id'      => $bankAccountId,
        ])->firstOrFail();

        $content = __('messages.notification.chatting.bank_account.content', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $lastMessageReceiver = __('messages.notification.chatting.bank_account.last_message_receiver', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $lastMessageSender = __('messages.notification.chatting.bank_account.last_message_sender');

        $messageId = $this->run(CreateBankAccountMessageOperation::class, [
            'sender'      => $sender,
            'threadFuid'  => $this->threadFuid,
            'text'        => $content,
            'id'          => $this->messageId,
            'bankAccount' => $bankAccount,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    private function createShippingCompanyMessage($shippingCompany): array
    {
        $sender = $this->getSender();

        $content = __('messages.notification.chatting.shipping_company.content', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $lastMessageReceiver = $content;
        $lastMessageSender   = $content;

        $messageId = $this->run(CreateShippingCompanyMessageOperation::class, [
            'sender'          => $sender,
            'threadFuid'      => $this->threadFuid,
            'text'            => $content,
            'id'              => $this->messageId,
            'shippingCompany' => $shippingCompany,
        ]);

        return [$messageId, $lastMessageSender, $lastMessageReceiver];
    }

    /**
     * @param string  $lastMessageSender
     * @param string  $lastMessageReceiver
     * @param string  $type
     * @param Message $result
     *
     * @throws ReflectionException
     */
    private function backgroundOperationHandler(string $lastMessageSender, string $lastMessageReceiver, string $type, Message $result)
    {
        $sender = $this->getSender();

        $title = trans('messages.notification.nickname', ['nickname' => $sender->nickname]);

        $contentPush = match ($type) {
            MessageType::TEXT             => __('messages.notification.chatting.text.content', ['nickname' => $sender->nickname]),
            MessageType::IMAGE            => __('messages.notification.chatting.image.content', ['nickname' => $sender->nickname]),
            MessageType::STICKER          => __('messages.notification.chatting.sticker.content', ['nickname' => $sender->nickname]),
            MessageType::LOCATION         => __('messages.notification.chatting.location.content', ['nickname' => $sender->nickname]),
            MessageType::SHIPPING_ADDRESS => __('messages.notification.chatting.shipping_address.content', ['nickname' => $sender->nickname]),
            MessageType::BANK_ACCOUNT     => __('messages.notification.chatting.bank_account.content', ['nickname' => $sender->nickname]),
            MessageType::SHIPPING_COMPANY => __('messages.notification.chatting.shipping_company.content', ['nickname' => $sender->nickname]),
        };

        $this->pushNotification($title, $contentPush, $type, $result);
        $this->updateLatestMessage($lastMessageSender, $lastMessageReceiver, $result);
        $this->markUserReplied();
    }

    /**
     * @param string  $title
     * @param string  $content
     * @param string  $typeChat
     * @param Message $message
     *
     * @throws ReflectionException
     */
    private function pushNotification(string $title, string $content, string $typeChat, Message $message)
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
                    'image'       => $message->attachment,
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
     * @param string  $lastMessageSender
     * @param string  $lastMessageReceiver
     * @param Message $result
     *
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
