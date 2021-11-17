<?php

namespace App\Operations;

use App\Domains\Chatting\Jobs\CreateOrderReceivedMessageJob;
use App\Domains\Chatting\Jobs\UpdateMessageJob;
use App\Enum\MessageType;
use App\Models\Firestore\Thread;
use App\Services\BaseOperation;
use App\Services\Chatting\Operations\CreateReviewMessageOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use Illuminate\Support\Facades\Auth;

class CreateCompleteProductMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private string $threadFuid;
    private string $messageId;
    private Thread|null $thread;
    private bool   $isStore = false;


    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid, string $messageId)
    {
        $this->threadFuid = $threadFuid;
        $this->messageId  = $messageId;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $this->thread  = Thread::query()->find($this->threadFuid);
        $sender    = $this->getSender();

        $text = __('messages.notification.chatting.order_received.content', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $this->run(UpdateMessageJob::class, [
            'docId'  => $this->messageId,
            'values' => [
                'shipping_company.is_confirmed' => true,
            ]
        ]);

        $message = $this->run(CreateOrderReceivedMessageJob::class, [
            'threadFuid' => $this->threadFuid,
            'user'       => Auth::user(),
            'text'       => $text,
        ]);

        $this->run(CreateReviewMessageOperation::class, [
            'user'       => Auth::user(),
            'threadFuid' => $this->threadFuid,
        ]);

        $this->backgroundOperationHandler($text, $text, MessageType::ORDER_RECEIVED, $message);
    }
}
