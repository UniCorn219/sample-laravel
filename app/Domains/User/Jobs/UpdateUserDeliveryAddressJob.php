<?php

namespace App\Domains\User\Jobs;

use App\Models\UserDeliveryAddress;
use Lucid\Units\Job;

class UpdateUserDeliveryAddressJob extends Job
{
    private int $deliveryId;
    private array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $deliveryId, array $data)
    {
        $this->deliveryId = $deliveryId;
        $this->data       = $data;
    }

    /**
     * @return bool|int
     */
    public function handle()
    {
        $userDelivery = UserDeliveryAddress::query()->findOrFail($this->deliveryId);

        if ($this->data['is_default']) {
            $this->changeNormalAddress($this->deliveryId);
        }

        return $userDelivery->update($this->data);
    }

    /**
     * @return bool
     */
    public function changeNormalAddress($deliveryId)
    {
        return UserDeliveryAddress::query()
            ->where('is_default', true)
            ->where('id', '<>', $deliveryId)
            ->update([
                'is_default' => false
            ]);
    }
}
