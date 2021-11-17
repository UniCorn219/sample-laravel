<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\CreateMessageJob;
use App\Domains\Chatting\Jobs\GetMessageInstanceJob;
use App\Enum\MessageType;
use App\Models\Product;
use App\Models\ProductTransactionable;
use App\Models\User;
use App\Services\BaseOperation;
use App\Services\Chatting\Traits\BackgroundOperationTrait;
use App\ValueObjects\Amount;
use DateTime;
use Google\Cloud\Core\Timestamp;

class CreateUserPayedMessageOperation extends BaseOperation
{
    use BackgroundOperationTrait;

    private Amount                 $amount;
    private mixed                  $amountType;
    private mixed                  $amountRate;
    private bool                   $isStore = false;
    private mixed                  $buyerId;
    private mixed                  $sellerId;
    private mixed                  $productId;
    private ProductTransactionable $transactionable;

    private User   $seller;
    private User   $buyer;
    private        $thread;
    private string $threadFuid;

    /**
     * CreateUserPayedMessageOperation constructor.
     * @param Amount $amount
     * @param $amountType
     * @param $amountRate
     * @param $buyerId
     * @param $sellerId
     * @param $productId
     * @param ProductTransactionable $transactionable
     */
    public function __construct(Amount $amount, mixed $amountType, mixed $amountRate, mixed $buyerId, mixed $sellerId, mixed $productId, ProductTransactionable $transactionable)
    {
        $this->amount          = $amount;
        $this->amountType      = $amountType;
        $this->amountRate      = $amountRate;
        $this->buyerId         = $buyerId;
        $this->sellerId        = $sellerId;
        $this->productId       = $productId;
        $this->transactionable = $transactionable;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $product      = Product::find($this->productId);
        $this->seller = User::findOrFail($this->sellerId);
        $this->buyer  = User::findOrFail($this->buyerId);
        $moneyAmount  = number_format($product->price);

        $this->amount->multiply($this->amountRate);
        $messageText = __('messages.notification.chatting.user_payed.content', [
            'nickname'      => $this->buyer->nickname,
            'fantasyAmount' => $this->amount->amount(),
            'moneyAmount'   => $moneyAmount,
        ]);

        $this->thread     = (object)$this->findOrCreateThread();
        $this->threadFuid = $this->thread->id;

        $message = $this->createMessage($messageText, $moneyAmount);

        $this->backgroundOperationHandler($messageText, $messageText, MessageType::USER_PAYED, $message, $this->amount, $moneyAmount);

        return $message;
    }

    private function findOrCreateThread()
    {
        return $this->run(CreateThreadOperation::class, [
            'userFuid'      => $this->buyer->firebase_uid,
            'otherUserFuid' => $this->seller->firebase_uid,
            'productId'     => $this->productId,
            'userId'        => $this->buyer->id,
            'otherUserId'   => $this->seller->id,
        ]);
    }

    private function createMessage(string $text, $moneyAmount)
    {
        $attributes = [
            'type'        => MessageType::USER_PAYED,
            'text'        => $text,
            'attachment'  => null,
            'sender'      => [
                'fuid'     => $this->buyer->firebase_uid,
                'name'     => $this->buyer->name,
                'nickname' => $this->buyer->nickname,
            ],
            'address'     => null,
            'sticker'     => null,
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->thread->id,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
            'amount'      => $moneyAmount,
            'amount_rate' => $this->amountRate,
            'amount_type' => $this->amountType,
        ];

        $messageId = $this->run(CreateMessageJob::class, [
            'attributes' => $attributes,
        ]);

        return $this->run(GetMessageInstanceJob::class, [
            'attributes' => $attributes,
            'messageId'  => $messageId,
        ]);
    }
}
