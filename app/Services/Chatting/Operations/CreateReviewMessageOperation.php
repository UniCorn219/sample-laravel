<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\CreateMessageJob;
use App\Domains\Chatting\Jobs\GetMessageInstanceJob;
use App\Domains\Chatting\Jobs\UpdateMessageJob;
use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Firestore\Thread;
use App\Models\User;
use App\Services\BaseOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;

class CreateReviewMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private User        $user;
    private string      $threadFuid;
    private Thread|null $thread;
    private bool        $isStore = false;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User $user, string $threadFuid)
    {
        $this->user          = $user;
        $this->threadFuid    = $threadFuid;

        $this->thread = Thread::query()->find($this->threadFuid);
    }

    /**
     * Execute the operation.
     *
     * @return Message
     */
    public function handle()
    {
        $messageText = __('messages.notification.chatting.review.content', [
            'nickname'      => $this->user->nickname,
        ]);

        $message = $this->createMessage($messageText);

        $this->backgroundOperationHandler($messageText, $messageText, MessageType::REVIEW, $message);

        return $message;
    }

    private function createMessage(string $text)
    {
        $attributes = [
            'type'                => MessageType::REVIEW,
            'text'                => $text,
            'attachment'          => null,
            'sender'              => [
                'fuid'     => $this->user->firebase_uid,
                'name'     => $this->user->name,
                'nickname' => $this->user->nickname,
            ],
            'address'             => null,
            'sticker'             => null,
            'reservation'         => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid'         => $this->threadFuid,
            'is_read'             => false,
            'created_at'          => new Timestamp(new DateTime()),
            'updated_at'          => new Timestamp(new DateTime()),
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
