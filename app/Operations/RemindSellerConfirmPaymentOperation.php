<?php

namespace App\Operations;

use App\Domains\Notification\Jobs\NotificationReminderForSellerJobQueue;
use App\Models\ProductTransactionable;
use App\Models\SafePaymentReminder;
use App\Services\BaseQueueableOperation;

class RemindSellerConfirmPaymentOperation extends BaseQueueableOperation
{
    private ProductTransactionable $transactionable;
    private int                    $dayDiff;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(ProductTransactionable $transactionable, int $dayDiff)
    {
        $this->transactionable = $transactionable;
        $this->dayDiff         = $dayDiff;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $result = $this->runInQueue(NotificationReminderForSellerJobQueue::class, [
            'productTransactionAble' => $this->transactionable,
        ]);

        if ($result) {
            SafePaymentReminder::query()->create([
                'transactionable_id' => $this->transactionable->id,
                'day_diff'          => $this->dayDiff,
            ]);
        }
    }
}
