<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Domains\Chatting\Requests\CreatePayCoinRequest;
use App\Domains\User\Jobs\GetUserInfo;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Firestore\UserThread;
use App\Models\User;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\CreatePayCoinMsgOperation;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use App\Services\Notification\Operations\PushNotificationOperation;

class CreatePayCoinFeature extends BaseFeatures
{
    public function handle(CreatePayCoinRequest $request)
    {
        $senderId    = $request->get('sender_id');
        $threadFuid  = $request->get('thread_fuid');
        $tokenNumber = $request->get('token_number');

        $sender = User::findOrFail($senderId);

        $thread = $this->run(GetThreadInfoJob::class, ['threadFuid' => $threadFuid]);

        $message = __('messages.chatting.paycoin.create', [
            'nickname' => $sender->nickname,
            'tokenNo'  => $tokenNumber
        ]);

        $lastMessageReceiver = __('messages.chatting.paycoin.last_message_receiver', [
            'nickname' => $sender->nickname,
            'tokenNo'  => $tokenNumber
        ]);

        $lastMessageSender = __('messages.chatting.paycoin.last_message_sender', [
            'tokenNo'  => $tokenNumber
        ]);

        $result = $this->run(CreatePayCoinMsgOperation::class, [
            'text'       => $message,
            'threadFuid' => $threadFuid,
            'sender'     => $sender,
        ]);

        $this->runInQueue(UpdateLatestMessageOperation::class, [
            'threadFuid'          => $threadFuid,
            'userFuid'            => $sender->firebase_uid,
            'lastMessageSender'   => $lastMessageSender,
            'lastMessageReceiver' => $lastMessageReceiver,
            'result'              => $result,
        ]);


        $actionType = $this->getActionTypeChatting($thread);
        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $threadFuid,
            'title'             => $sender->nickname,
            'content'           => $message,
            'sender'            => $sender,
            'senderFirebaseUid' => $sender->firebase_uid,
            'isStore'           => false,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => $actionType,
                    'target_id'   => $threadFuid,
                    'sender'      => $sender,
                    'isStoreSend' => false,
                ]
            ],
            'actionType'        => $actionType
        ]);

        return $this->responseOk();
    }

    private function getActionTypeChatting($thread): int
    {
        if ($thread['has_product']) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT;
        }

        return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
    }
}
