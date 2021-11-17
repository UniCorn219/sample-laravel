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
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;

class CreateReviewedMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private User        $user;
    private string      $threadFuid;
    private string      $messageId;
    private Thread|null $thread;
    private bool        $isStore = false;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User $user, string $threadFuid, string $messageId)
    {
        $this->user          = $user;
        $this->threadFuid    = $threadFuid;
        $this->messageId     = $messageId;

        $this->thread = Thread::query()->find($this->threadFuid);
    }

    /**
     * Execute the operation.
     *
     * @return Message
     */
    public function handle()
    {
        $messageText = __('messages.notification.chatting.reviewed.content', [
            'nickname'      => $this->user->nickname,
        ]);

        $message = Message::query()->find($this->messageId);
        $this->updateMessage($message);

        $this->backgroundOperationHandler($messageText, $messageText, MessageType::REVIEW, $message);

        return $message;
    }

    private function updateMessage($message)
    {
        $reviewIds = $message->reviewer_ids ?: [];
        array_push($reviewIds, $this->user->firebase_uid);

        $this->run(UpdateMessageJob::class, [
            'docId' => $this->messageId,
            'values' => [
                'reviewer_ids' => $reviewIds,
            ]
        ]);
    }

    private function getSender()
    {
        return $this->user;
    }
}
