<?php

namespace App\Domains\Product\Jobs;

use App\Domains\User\Jobs\GetRewardSettingJob;
use App\ValueObjects\Amount;
use Lucid\Units\QueueableJob;

class RewardTokenWhenCreateProductSuccess extends QueueableJob
{
    const TYPE_REWARD_FOR_CREATED_PRODUCT_O2O = 8;

    private string $userUniqid;

    /**
     * RewardTokenWhenCreateProductSuccess constructor.
     * @param $userUniqid
     */
    public function __construct($userUniqid)
    {
        $this->userUniqid = $userUniqid;
    }

    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle()
    {
        $settingReward             = new GetRewardSettingJob();
        $rewardSetting             = $settingReward->handle();
        $keyRewardCreateProductO2o = array_search(self::TYPE_REWARD_FOR_CREATED_PRODUCT_O2O, array_column($rewardSetting, 'type'));
        $amountCreateProductO2o    = isset($rewardSetting[$keyRewardCreateProductO2o]['point']) ? (int)$rewardSetting[$keyRewardCreateProductO2o]['point'] : 0;
        $reasonReward              = isset($rewardSetting[$keyRewardCreateProductO2o]['reason']) ? (string)$rewardSetting[$keyRewardCreateProductO2o]['reason'] : '';

        $reward = new ChangeBalanceTokenJob($this->userUniqid, Amount::create($amountCreateProductO2o), $reasonReward);
        $reward->handle();
    }
}
