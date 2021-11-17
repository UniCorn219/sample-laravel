<?php

namespace App\Operations;

use App\Domains\Chatting\Jobs\Message\CreateSystemCancelPaymentMessageJob;
use App\Domains\Notification\Jobs\NotificationSystemAutoCancelWhenSellerNotConfirmJobQueue;
use App\Domains\Product\Jobs\UpdateProductRevertToSellingJob;
use App\Domains\Transaction\Jobs\CancelProductTransactionableJob;
use App\Domains\Transaction\Jobs\FindOrFailTransactionDetailJob;
use App\Domains\Transaction\Jobs\UpdateTransactionStatus;
use App\Domains\TransactionLog\Jobs\CreateTransactionLogJob;
use App\Domains\Wallet\Jobs\CancelPaymentJob;
use App\Enum\ActorType;
use App\Enum\ProductOrderStatus;
use App\Enum\TransactionableType;
use App\Enum\TransactionStatus;
use App\Exceptions\BusinessException;
use App\Models\PaymentTransaction;
use App\Models\ProductTransactionable;
use App\Models\SafePaymentReminder;
use App\Models\User;
use App\Services\BaseQueueableOperation;
use App\Services\Chatting\Operations\CreateThreadOperation;
use App\Services\Chatting\Operations\UpdateLatestMessageOperation;
use Illuminate\Support\Facades\DB;
use ReflectionException;
use Throwable;

class AutoCancelPaymentOperation extends BaseQueueableOperation
{
    /**
     * @var ProductTransactionable
     */
    private ProductTransactionable $transactionAble;

    private int  $dayDiff;
    private User $seller;
    private User $buyer;

    /**
     * AutoCancelPaymentOperation constructor.
     * @param ProductTransactionable $transactionAble
     * @param int $dayDiff
     */
    public function __construct(ProductTransactionable $transactionAble, int $dayDiff, User $seller, User $buyer)
    {
        $this->transactionAble = $transactionAble;
        $this->dayDiff         = $dayDiff;
        $this->seller          = $seller;
        $this->buyer           = $buyer;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function handle()
    {
        $this->cancel();

        $this->runInQueue(NotificationSystemAutoCancelWhenSellerNotConfirmJobQueue::class, [
            'productTransactionAble' => $this->transactionAble,
        ]);

        SafePaymentReminder::query()->create([
            'transactionable_id' => $this->transactionAble->id,
            'day_diff'           => $this->dayDiff,
        ]);

        $thread = (object) $this->findOrCreateThread($this->transactionAble->product_id);

        $this->createMessageAndUpdateLastMessageSystemCancelPayment($thread->id);
    }

    /**
     * @param $threadFuid
     * @return bool
     * @throws ReflectionException
     */
    protected function createMessageAndUpdateLastMessageSystemCancelPayment($threadFuid): bool
    {
        $text = __('messages.notification.chatting.system.auto_cancel_payment');

        [$result, $lastMessageSender, $lastMessageReceiver] = $this->createSystemCancelPaymentMessage($threadFuid, $text);

        $this->run(UpdateLatestMessageOperation::class, [
            'threadFuid'          => $threadFuid,
            'userFuid'            => $this->seller->firebase_uid,
            'lastMessageSender'   => $lastMessageSender,
            'lastMessageReceiver' => $lastMessageReceiver,
            'result'              => $result,
        ]);

        return true;
    }

    /**
     * @param $productId
     * @return mixed
     */
    private function findOrCreateThread($productId)
    {
        return $this->run(CreateThreadOperation::class, [
            'userFuid'      => $this->buyer->firebase_uid,
            'otherUserFuid' => $this->seller->firebase_uid,
            'productId'     => $productId,
            'userId'        => $this->buyer->id,
            'otherUserId'   => $this->seller->id,
        ]);
    }

    /**
     * @param $threadFuid
     * @param $text
     * @return array
     */
    private function createSystemCancelPaymentMessage($threadFuid, $text): array
    {
        $message = $this->run(CreateSystemCancelPaymentMessageJob::class, [
            'threadFuid' => $threadFuid,
            'text'       => $text
        ]);

        $lastMessageSender   = $text;
        $lastMessageReceiver = $text;

        return [$message, $lastMessageSender, $lastMessageReceiver];
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function cancel(): bool
    {
        $paymentTransaction = PaymentTransaction::where('id', $this->transactionAble->id)
            ->where('transactionable_type', TransactionableType::PRODUCT)
            ->first();

        $productId            = $this->transactionAble->product_id;
        $paymentTransactionId = $paymentTransaction->id;

        $paymentTransactionValidated = $this->validateTransaction($paymentTransactionId);

        $cancelResponse = $this->cancelPayment($paymentTransactionValidated);

        DB::transaction(function () use ($paymentTransactionValidated, $paymentTransactionId, $productId) {
            $this->cancelProductTransactionable($paymentTransactionValidated, (string)'reason cancel');
            $this->updateTransactionStatus($paymentTransactionId);
            $this->updateProductRevertToSelling($productId);
        });

        $this->createTransactionLog($paymentTransactionValidated, $cancelResponse);

        return true;
    }

    /**
     * @param $transactionId
     * @return PaymentTransaction
     * @throws Throwable
     */
    protected function validateTransaction($transactionId): PaymentTransaction
    {
        /** @var PaymentTransaction $transaction */
        $transaction = $this->run(FindOrFailTransactionDetailJob::class, ['id' => $transactionId]);

        $status = $transaction->transactionable->order_status ?? 0;
        throw_if(
            !in_array($status, [ProductOrderStatus::PROCESSING, ProductOrderStatus::ACCEPTED]),
            BusinessException::class,
            __('messages.product.only_cancel_when_order_status_processing_or_accepted')
        );

        return $transaction;
    }

    /**
     * @param PaymentTransaction $transaction
     * @return mixed
     */
    protected function cancelPayment(PaymentTransaction $transaction): mixed
    {
        return $this->run(CancelPaymentJob::class, ['txid' => $transaction->transactionable->txid ?? ""]);
    }

    /**
     * @param PaymentTransaction $transaction
     * @param string $reason
     */
    protected function cancelProductTransactionable(PaymentTransaction $transaction, string $reason)
    {
        $this->run(CancelProductTransactionableJob::class, [
            'id'     => $transaction->transactionable_id,
            'reason' => $reason,
        ]);
    }

    /**
     * @param $paymentTransactionId
     */
    protected function updateTransactionStatus($paymentTransactionId)
    {
        $this->run(UpdateTransactionStatus::class, [
            'id'     => $paymentTransactionId,
            'status' => TransactionStatus::CANCELLED,
        ]);
    }

    /**
     * @param $productId
     */
    protected function updateProductRevertToSelling($productId)
    {
        $this->run(UpdateProductRevertToSellingJob::class, [
            'id' => $productId,
        ]);
    }

    /**
     * @param PaymentTransaction $transaction
     * @param mixed $payload
     */
    protected function createTransactionLog(PaymentTransaction $transaction, mixed $payload)
    {
        $this->run(CreateTransactionLogJob::class, [
            'transactionId'     => $transaction->id,
            'transactionStatus' => TransactionStatus::CANCELLED,
            'userId'            => $transaction->transactionable->buyer_id ?? 0,
            'amount'            => $transaction->amount,
            'amountType'        => $transaction->amount_type,
            'amountRate'        => $transaction->amount_rate,
            'actorId'           => $transaction->transactionable->buyer_id ?? 0,
            'actorType'         => ActorType::USER,
            'payload'           => json_encode($payload),
        ]);
    }
}
