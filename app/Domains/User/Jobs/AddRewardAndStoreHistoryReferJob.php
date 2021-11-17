<?php

namespace App\Domains\User\Jobs;

use App\Domains\Notification\Jobs\PushAndSaveNotificationInviteMemberJob;
use App\Models\IntroduceMemberHistories;
use App\Models\User;
use App\Services\FCM\FCMService;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableOperation;

class AddRewardAndStoreHistoryReferJob extends QueueableOperation
{
    const TYPE_REWARD_REVIEW_NORMAL              = 1;
    const TYPE_REWARD_REVIEW_USED_PHONE          = 2;
    const TYPE_REWARD_REQUEST_COMPLETE           = 3;
    const TYPE_REWARD_LOGIN_NORMAL               = 4;
    const TYPE_REWARD_FOR_REFER_USER             = 5;
    const TYPE_REWARD_REQUEST_COMPLETE_FOR_REFER = 6;
    const TYPE_REWARD_FOR_9_REFER_USER           = 7;

    private int $userId;

    /**
     * UpdateLinkShareJob constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $user = User::find($this->userId);

        if ($user->refer && $user->refer_user) {
            $userIntroduceMember = User::find($user->refer_user);

            if (empty($userIntroduceMember)) {
                return true;
            }

            $totalIntroduceMember = IntroduceMemberHistories::where('presenter_id', $userIntroduceMember->id)->count();

            DB::transaction(function () use ($user, $userIntroduceMember, $totalIntroduceMember) {
                $pointSetting    = $this->run(GetRewardSettingJob::class);
                $keyRewardRefer  = array_search(self::TYPE_REWARD_FOR_REFER_USER, array_column($pointSetting, 'type'));
                $keyReward9Refer = array_search(self::TYPE_REWARD_FOR_9_REFER_USER, array_column($pointSetting, 'type'));

                if ($totalIntroduceMember < 8) {
                    $pointRefer = isset($pointSetting[$keyRewardRefer]['point']) ? (int)$pointSetting[$keyRewardRefer]['point'] : 0;
                    $point = $pointRefer;

                    $introduceMemberHistories = IntroduceMemberHistories::create([
                        'presenter_id' => $user->refer_user,
                        'user_id'      => $user->id,
                        'phone'        => $user->phone,
                        'point'        => $point
                    ]);

                    (new PushAndSaveNotificationInviteMemberJob($user, $userIntroduceMember, $introduceMemberHistories))->handle();
                } else if ($totalIntroduceMember == 8) {
                    $pointRefer = isset($pointSetting[$keyRewardRefer]['point']) ? (int)$pointSetting[$keyRewardRefer]['point'] : 0;
                    $point9Refer = isset($pointSetting[$keyReward9Refer]['point']) ? (int)$pointSetting[$keyReward9Refer]['point'] : 0;
                    $point = $pointRefer + $point9Refer;

                    $introduceMemberHistories = IntroduceMemberHistories::create([
                        'presenter_id' => $user->refer_user,
                        'user_id'      => $user->id,
                        'phone'        => $user->phone,
                        'point'        => $point
                    ]);

                    (new PushAndSaveNotificationInviteMemberJob($user, $userIntroduceMember, $introduceMemberHistories))->handle();
                } else {
                    $point = 0;

                    IntroduceMemberHistories::create([
                        'presenter_id' => $user->refer_user,
                        'user_id'      => $user->id,
                        'phone'        => $user->phone,
                        'point'        => $point
                    ]);
                }
            });
        }

        return true;
    }
}
