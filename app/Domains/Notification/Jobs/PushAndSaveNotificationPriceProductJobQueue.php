<?php

namespace App\Domains\Notification\Jobs;

use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\NotificationType;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\User;
use Lucid\Units\QueueableJob;
use Throwable;

class PushAndSaveNotificationPriceProductJobQueue extends QueueableJob
{
    /**
     * @var Product
     */
    protected Product $product;

    /**
     * PushAndSaveNotificationPriceProductJobQueue constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function handle(): mixed
    {
        $owner = User::find($this->product->author_id);

        $userIdsLikedProduct = ProductLike::where('product_id', $this->product->id)->get()->pluck('user_id');
        if (empty($userIdsLikedProduct)) {
            return false;
        }
        $usersLike = User::whereIn('id', $userIdsLikedProduct)->get();

        foreach ($usersLike as $userLike) {
            $notificationId = $this->saveNotification($owner, $userLike);
            $this->pushNotification($userLike, $notificationId);
        }

        return true;
    }

    /**
     * @param $userLike
     * @param $notificationId
     * @return bool
     */
    public function pushNotification($userLike, $notificationId): bool
    {
        $lang  = $userLike->setting?->language ?? 'ko';
        $token = $userLike->token_fcm;

        app()->setLocale($lang);

        $title   = trans('messages.notification.product.change_price.title', ['productName' => $this->product->title]);
        $content = trans('messages.notification.product.change_price.content', ['productName' => $this->product->title]);

        $options = [
            'type' => NotificationType::PRODUCT,
            'data' => [
                'navigate'        => NotificationType::NAVIGATE['PRODUCT_SCREEN'],
                'action_type'     => NotificationAction::PRODUCT_CHANGED,
                'target_id'       => $this->product->id,
                'product'         => $this->product,
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
     * @param $owner
     * @param $userLike
     * @return bool|int
     */
    public function saveNotification($owner, $userLike)
    {
        $notification = new StoreNotificationJob(
            EntityMorphType::PRODUCT,
            $this->product->id,
            $owner->id,
            $userLike->id,
            NotificationAction::PRODUCT_CHANGED,
            EntityMorphType::USER,
            $owner->id
        );

        try {
            return $notification->handle();
        } catch (Throwable) {
            return false;
        }
    }
}
