<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Requests\CreatePayCoinMessageRequest;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Product;
use App\Models\User;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\CreatePayCoinMsgOperation;
use App\Services\Chatting\Operations\CreateThreadOperation;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use App\Services\Notification\Operations\PushNotificationOperation;

class CreatePayCoinMessageFeature extends BaseFeatures
{
    public function handle(CreatePayCoinMessageRequest $request)
    {
        $buyerId     = $request->get('buyer_id');
        $sellerId    = $request->get('seller_id');
        $productId   = $request->get('product_id');
        $tokenAmount = $request->get('token_amount');

        $buyer   = User::query()->findOrFail($buyerId);
        $seller  = User::query()->findOrFail($sellerId);
        $product = Product::query()->findOrFail($productId);

        $thread = (object)$this->findOrCreateThread($buyer, $seller, $product);
        $message = __('messages.chatting.paycoin.create', [
            'nickname' => $buyer->nickname,
            'tokenNo'  => $tokenAmount
        ]);

        $lastMessageReceiver = __('messages.chatting.paycoin.last_message_receiver', [
            'nickname' => $buyer->nickname,
            'tokenNo'  => $tokenAmount
        ]);

        $lastMessageSender = __('messages.chatting.paycoin.last_message_sender', [
            'tokenNo'  => $tokenAmount
        ]);

        $result = $this->run(CreatePayCoinMsgOperation::class, [
            'text'       => $message,
            'threadFuid' => $thread->id,
            'sender'     => $buyer,
        ]);

        $this->runInQueue(UpdateLatestMessageOperation::class, [
            'threadFuid'          => $thread->id,
            'userFuid'            => $buyer->firebase_uid,
            'lastMessageSender'   => $lastMessageSender,
            'lastMessageReceiver' => $lastMessageReceiver,
            'result'              => $result,
        ]);


        $actionType = $this->getActionTypeChatting($thread);
        $this->runInQueue(PushNotificationOperation::class, [
            'threadFuid'        => $thread->id,
            'title'             => $buyer->nickname,
            'content'           => $message,
            'sender'            => $buyer,
            'senderFirebaseUid' => $buyer->firebase_uid,
            'isStore'           => false,
            'options'           => [
                'type' => NotificationType::CHAT,
                'data' => [
                    'navigate'    => NotificationType::NAVIGATE['CHATTING_SCREEN'],
                    'action_type' => $actionType,
                    'target_id'   => $thread->id,
                    'sender'      => $buyer,
                    'isStoreSend' => false,
                ]
            ],
            'actionType'        => $actionType
        ]);

        return $this->responseOk($result);
    }

    private function findOrCreateThread(User $buyer, User $seller, Product $product)
    {
        return $this->run(CreateThreadOperation::class, [
            'userFuid'      => $buyer->firebase_uid,
            'otherUserFuid' => $seller->firebase_uid,
            'productId'     => $product->id,
            'userId'        => $buyer->id,
            'otherUserId'   => $seller->id,
        ]);
    }

    private function getActionTypeChatting($thread): int
    {
        if ($thread->has_product) {
            return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT;
        }

        return NotificationAction::CREATE_MESSAGE_IN_USER_AND_USER;
    }
}
