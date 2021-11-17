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
 * Class NotificationSystemAutoCancelWhenSellerNotConfirmJobQueue
 * @package App\Domains\Notification\Jobs
 */
class NotificationSystemAutoCancelWhenSellerNotConfirmJobQueue extends QueueableJob
{
    protected ProductTransactionable $productTransactionAble;

    /**
     * NotificationSystemAutoCancelWhenSellerNotConfirmJobQueue constructor.
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
        $notificationSellerId = $this->saveNotificationSeller($productTransactionAble);
        $this->pushNotificationSeller($productTransactionAble, $notificationSellerId);
        $notificationBuyerId = $this->saveNotificationBuyer($productTransactionAble);
        $this->pushNotificationBuyer($productTransactionAble, $notificationBuyerId);

        return true;
    }

    /**
     * @param $productTransactionAble
     * @param $notificationId
     * @return bool
     */
    public function pushNotificationSeller($productTransactionAble, $notificationId)
    {
        if (!$notificationId) {
            return false;
        }

        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);

        $lang  = $seller->setting?->language ?? 'ko';
        $token = $seller->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.safe_payment.auto_cancel_product.title', ['productName' => $product->title]);
        $content = trans('messages.notification.safe_payment.auto_cancel_product.content', ['productName' => $product->title]);

        $options = [
            'type' => NotificationType::SAFE_PAYMENT,
            'data' => [
                'navigate'        => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type'     => NotificationAction::AUTO_CANCEL_PRODUCT,
                'target_id'       => $productTransactionAble->product_id,
                'notification_id' => $notificationId
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

    /**
     * @param $productTransactionAble
     * @return bool|int
     */
    public function saveNotificationSeller($productTransactionAble)
    {
        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);

        $notification = new StoreNotificationJob(
            EntityMorphType::PRODUCT,
            $product->id,
            $seller->id,
            $seller->id,
            NotificationAction::AUTO_CANCEL_PRODUCT,
            EntityMorphType::USER,
            $seller->id
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @param $productTransactionAble
     * @param $notificationId
     * @return bool
     */
    public function pushNotificationBuyer($productTransactionAble, $notificationId): bool
    {
        if (!$notificationId) {
            return false;
        }

        $product = Product::find($productTransactionAble->product_id);
        $buyer   = User::find($productTransactionAble->buyer_id);

        $lang  = $buyer->setting?->language ?? 'ko';
        $token = $buyer->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.safe_payment.auto_cancel_product.title', ['productName' => $product->title]);
        $content = trans('messages.notification.safe_payment.auto_cancel_product.content', ['productName' => $product->title]);

        $options = [
            'type' => NotificationType::SAFE_PAYMENT,
            'data' => [
                'navigate'        => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type'     => NotificationAction::AUTO_CANCEL_PRODUCT,
                'target_id'       => $productTransactionAble->product_id,
                'notification_id' => $notificationId
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

    /**
     * @param $productTransactionAble
     * @return bool
     */
    public function saveNotificationBuyer($productTransactionAble): bool
    {
        $product = Product::find($productTransactionAble->product_id);
        $buyer   = User::find($productTransactionAble->buyer_id);

        $notification = new StoreNotificationJob(
            EntityMorphType::PRODUCT,
            $product->id,
            $buyer->id,
            $buyer->id,
            NotificationAction::AUTO_CANCEL_PRODUCT,
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
