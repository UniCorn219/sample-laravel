<?php

namespace App\Operations;

use App\Domains\Chatting\Jobs\UpdateMessageJob;
use App\Enum\MessageType;
use App\Models\Firestore\Thread;
use App\Services\BaseOperation;
use App\Services\Chatting\Operations\CreateShippingCompanyMessageOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use DateTime;
use Google\Cloud\Core\Timestamp;

class CreateLogisticMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private bool        $isStore;
    private int|null    $storeId;
    private string      $threadFuid;
    private string      $messageId;
    private Thread|null $thread;
    private             $shippingCompany;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(int|null $storeId, string $threadFuid, $shippingCompany, $messageId)
    {
        $this->storeId         = $storeId;
        $this->threadFuid      = $threadFuid;
        $this->messageId       = $messageId;
        $this->shippingCompany = $shippingCompany;

        $this->isStore = !is_null($storeId);
        $this->thread  = Thread::query()->find($threadFuid);
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $sender = $this->getSender();

        $text = __('messages.notification.chatting.shipping_company.content', [
            'nickname' => $this->isStore ? $sender->name : $sender->nickname,
        ]);

        $message = $this->run(CreateShippingCompanyMessageOperation::class, [
            'sender'          => $sender,
            'threadFuid'      => $this->threadFuid,
            'text'            => $text,
            'shippingCompany' => $this->shippingCompany,
            'id'              => ''
        ]);

        $this->updateMessage();
        $this->backgroundOperationHandler($text, $text, MessageType::SHIPPING_COMPANY, $message);

        return $message;
    }

    private function updateMessage()
    {
        $this->run(UpdateMessageJob::class, [
            'docId' => $this->messageId,
            'values' => [
                'add_logistic_address_at' => new Timestamp(new DateTime()),
            ]
        ]);
    }
}
