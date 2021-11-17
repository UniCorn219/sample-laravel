<?php

namespace App\Domains\Product\Jobs;

use App\Models\UserKeyword;
use Lucid\Units\Job;

class ListUserReciveNotificationJob extends Job
{
    protected array $product;
    protected int   $ownerId;

    /**
     * ListUserReciveNotificationJob constructor.
     * @param array $product
     * @param int $ownerId
     */
    public function __construct(array $product, int $ownerId)
    {
        $this->product = $product;
        $this->ownerId = $ownerId;
    }

    /**
     * @return array
     */
    public function handle()
    {
        $productTitle   = $this->product['title'];
        $userGiveNotify = UserKeyword::query()
            ->where('user_id', '<>', $this->ownerId)
            ->get();

        $data = [];
        $userGiveNotify->map(function ($user) use ($productTitle, &$data) {
            if (str_contains(strtolower($productTitle), strtolower($user->keyword))) {
                $data[$user->user_id] = $user->keyword;
            }
        });

        return array_unique($data);
    }
}
