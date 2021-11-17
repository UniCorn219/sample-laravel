<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Product;
use App\Models\ProductTransactionable;
use App\Models\User;
use Lucid\Units\QueueableJob;
use Throwable;

/**
 * Class NotificationBuyerCancelProductJobQueue
 * @package App\Domains\Notification\Jobs
 */
class NotificationBuyerCancelProductJobQueue extends QueueableJob
{
    protected ProductTransactionable $productTransactionAble;

    /**
     * NotificationBuyerCancelProductJobQueue constructor.
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
        $this->pushAndSaveNotification($this->productTransactionAble);

        return true;
    }

    /**
     * @param $productTransactionAble
     * @return bool
     */
    protected function pushAndSaveNotification($productTransactionAble): bool
    {
        $notificationId = $this->saveNotification($productTransactionAble);
        $this->pushNotification($productTransactionAble, $notificationId);

        return true;
    }

    /**
     * @param $productTransactionAble
     * @param $notificationId
     * @return bool
     */
    public function pushNotification($productTransactionAble, $notificationId): bool
    {
        if (!$notificationId) {
            return false;
        }

        $buyer   = User::find($productTransactionAble->buyer_id);
        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);

        $lang  = $seller->setting?->language ?? 'ko';
        $token = $seller->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.safe_payment.buyer_cancel_product.title', ['productName' => $product->title]);
        $content = trans('messages.notification.safe_payment.buyer_cancel_product.content', ['buyerName' => $buyer->nickname]);

        $options = [
            'type' => NotificationType::SAFE_PAYMENT,
            'data' => [
                'navigate'        => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type'     => NotificationAction::BUYER_CANCEL_PRODUCT,
                'target_id'       => $productTransactionAble->product_id,
                'notification_id' => $notificationId
            ]
        ];

        $pushNotification = new PushNotificationJobNonQueue($token, $content, $title, $options);

        try {
            $pushNotification->handle();

            return true;
        } catch (Throwable) {
            return true;
        }
    }

    /**
     * @param $productTransactionAble
     * @return bool|int
     */
    public function saveNotification($productTransactionAble)
    {
        $buyer   = User::find($productTransactionAble->buyer_id);
        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);

        $notification = new StoreNotificationJob(
            EntityMorphType::PRODUCT,
            $product->id,
            $buyer->id,
            $seller->id,
            NotificationAction::BUYER_CANCEL_PRODUCT,
            EntityMorphType::USER,
            $buyer->id
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }
}
