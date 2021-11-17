<?php

namespace App\Operations;

use App\Domains\Chatting\Jobs\CreateMessageJob;
use App\Domains\Chatting\Jobs\GetMessageInstanceJob;
use App\Domains\Chatting\Jobs\UpdateMessageJob;
use App\Enum\MessageType;
use App\Models\Firestore\Thread;
use App\Models\User;
use App\Services\BaseOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Illuminate\Support\Facades\Auth;

class CreateCancelProductMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private User        $user;
    private string      $threadFuid;
    private string      $messageId;
    private Thread|null $thread;
    private bool        $isStore = false;
    private string      $reason;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid, string $reason, string $messageId)
    {
        $this->threadFuid = $threadFuid;
        $this->messageId  = $messageId;
        $this->reason     = $reason;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $this->user   = Auth::user();
        $this->thread = Thread::query()->find($this->threadFuid);
        $sender = $this->getSender();

        $text = __('messages.notification.chatting.user_cancel_payment.content', [
            'nickname' => $sender->nickname,
        ]);

        $message = $this->createMessage($text, $this->reason);
        $this->updateUserPayedMessage();

        $this->backgroundOperationHandler($text, $text, MessageType::USER_CANCEL_PAYMENT, $message);
    }

    private function updateUserPayedMessage()
    {
        $this->run(UpdateMessageJob::class, [
            'docId' => $this->messageId,
            'values' => [
                'cancel_at' => new Timestamp(new DateTime()),
            ]
        ]);
    }

    private function createMessage(string $text, string $reason)
    {
        $attributes = [
            'type'        => MessageType::USER_CANCEL_PAYMENT,
            'text'        => $text,
            'attachment'  => null,
            'sender'      => [
                'fuid'     => $this->user->firebase_uid,
                'name'     => $this->user->name,
                'nickname' => $this->user->nickname,
            ],
            'address'     => null,
            'sticker'     => null,
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->threadFuid,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
            'reason'      => $reason,
        ];

        $messageId = $this->run(CreateMessageJob::class, [
            'attributes' => $attributes,
        ]);

        return $this->run(GetMessageInstanceJob::class, [
            'attributes' => $attributes,
            'messageId'  => $messageId,
        ]);
    }

    private function getSender()
    {
        return $this->user;
    }
}
