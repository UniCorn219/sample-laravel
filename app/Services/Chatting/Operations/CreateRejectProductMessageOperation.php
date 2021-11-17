<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\UpdateMessageJob;
use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Firestore\Thread;
use App\Services\BaseOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use DateTime;
use Google\Cloud\Core\Timestamp;

class CreateRejectProductMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private bool        $isStore;
    private int|null    $storeId;
    private string      $threadFuid;
    private string      $messageId;
    private Thread|null $thread;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(int|null $storeId, string $threadFuid, string $messageId)
    {
        $this->storeId    = $storeId;
        $this->threadFuid = $threadFuid;
        $this->messageId  = $messageId;
        $this->isStore    = !is_null($storeId);
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $this->thread = Thread::query()->find($this->threadFuid);
        $sender       = $this->getSender();

        $text = __('messages.notification.chatting.user_payed.reject_payment', ['nickname' => $sender->nickname]);

        $message = $this->createMessage($text, $sender);
        $this->updateUserPayedMessage();
        $this->backgroundOperationHandler($text, $text, MessageType::SELLER_REJECT_PAYMENT, $message);
    }

    private function updateUserPayedMessage()
    {
        $this->run(UpdateMessageJob::class, [
            'docId'  => $this->messageId,
            'values' => [
                'rejected_at' => new Timestamp(new DateTime()),
            ]
        ]);
    }

    private function createMessage(string $text, $sender): Message
    {
        $attributes = [
            'type'        => MessageType::SELLER_REJECT_PAYMENT,
            'text'        => $text,
            'attachment'  => null,
            'sender'      => [
                'fuid'     => $sender->firebase_uid,
                'name'     => $sender->name,
                'nickname' => $sender->nickname,
            ],
            'address'     => [
                'lat'         => null,
                'long'        => null,
                'name'        => null,
                'description' => null,
            ],
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->threadFuid,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
        ];

        $messageId = Message::query()->insertGetId($attributes);

        return Message::query()->newModelInstance(
            array_merge(
                $attributes,
                ['id' => $messageId],
            )
        );
    }
}
