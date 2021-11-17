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
 * Class NotificationSellerRejectProductJobQueue
 * @package App\Domains\Notification\Jobs
 */
class NotificationSellerRejectProductJobQueue extends QueueableJob
{
    protected ProductTransactionable $productTransactionAble;

    /**
     * NotificationSellerRejectProductJobQueue constructor.
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
        $buyer   = User::find($productTransactionAble->buyer_id);
        $product = Product::find($productTransactionAble->product_id);
        $seller  = User::find($productTransactionAble->seller_id);
        if (empty($buyer)) {
            return false;
        }

        $lang  = $buyer->setting?->language ?? 'ko';
        $token = $buyer->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.safe_payment.seller_reject.title', ['productName' => $product->title]);
        $content = trans('messages.notification.safe_payment.seller_reject.content', ['sellerName' => $seller->nickname]);

        $options = [
            'type' => NotificationType::SAFE_PAYMENT,
            'data' => [
                'navigate'    => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type' => NotificationAction::SELLER_REJECT,
                'target_id'   => $productTransactionAble->product_id
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
}
