<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Product;
use App\Models\ProductTransactionable;
use App\Models\User;
use Lucid\Units\QueueableJob;
use Throwable;

/**
 * Class NotificationReminderForSellerJobQueue
 * @package App\Domains\Notification\Jobs
 */
class NotificationReminderForSellerJobQueue extends QueueableJob
{
    protected ProductTransactionable $productTransactionAble;

    /**
     * NotificationReminderForSellerJobQueue constructor.
     * @param ProductTransactionable $productTransactionAble
     */
    public function __construct(ProductTransactionable $productTransactionAble)
    {
        $this->productTransactionAble = $productTransactionAble;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $this->pushNotification($this->productTransactionAble);

        return true;
    }

    /**
     * @param $productTransactionAble
     * @return bool
     */
    public function pushNotification($productTransactionAble): bool
    {
        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);
        if (empty($seller)) {
            return false;
        }

        $lang  = $seller->setting?->language ?? 'ko';
        $token = $seller->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.safe_payment.reminder_seller_accept.title', ['productName' => $product->title]);
        $content = trans('messages.notification.safe_payment.reminder_seller_accept.content', ['productName' => $product->title]);

        $options = [
            'type' => NotificationType::SAFE_PAYMENT,
            'data' => [
                'navigate'    => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type' => NotificationAction::REMINDER_SELLER,
                'target_id'   => $productTransactionAble->product_id
            ]
        ];

        $pushNotification = new PushNotificationJobNonQueue($token, $content, $title, $options);

        try {
            $pushNotification->handle();

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
