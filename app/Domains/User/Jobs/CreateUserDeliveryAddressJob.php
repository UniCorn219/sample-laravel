<?php

namespace App\Domains\User\Jobs;

use App\Models\UserDeliveryAddress;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class CreateUserDeliveryAddressJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        if ($this->checkMaxDeliveryAddress($this->param['user_id'])) {
            throw ValidationException::withMessages(['Limit ' . UserDeliveryAddress::MAX_ADDRESS . 'delivery address.']);
        }

        if ($this->param['is_default']) {
            $this->changeNormalAddress();
        }

        return UserDeliveryAddress::query()
            ->create($this->param);
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkMaxDeliveryAddress($userId)
    {
        $totalDeliveryAddress = UserDeliveryAddress::query()
            ->where('user_id', $userId)
            ->count();

        return $totalDeliveryAddress >= UserDeliveryAddress::MAX_ADDRESS;
    }

    /**
     * @return bool
     */
    public function changeNormalAddress()
    {
        $defaultAddress = UserDeliveryAddress::query()->where('is_default', true)->first();

        if ($defaultAddress) {
            $defaultAddress->is_default = false;
            $defaultAddress->save();
        }

        return true;
    }
}
