<?php

namespace App\Domains\User\Jobs;

use App\Models\IntroduceMemberHistories;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;
use App\Services\FCM\FCMService;
use Illuminate\Support\Facades\DB;
use App\Models\PointSetting;

class IntroduceMemberHistoryJob extends Job
{
    private int $userId;

    const DEFAULT_POINT_INTRODUCE_MEMBER = 300;
    const BONUS_POINT_INTRODUCE_MEMBER   = 5000;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return Collection|Model|User|boolean
     */
    public function handle(): User|Collection|Model|bool
    {
        $user = User::find($this->userId);

        if (empty($user)) {
            return false;
        }

        if ($user->refer && $user->refer_user) {
            $userIntroduceMenber = User::find($user->refer_user);

            if (empty($userIntroduceMenber)) {
                return false;
            }

            DB::transaction(function () use ($user, $userIntroduceMenber) {
                $totalIntroduceMember = IntroduceMemberHistories::where('presenter_id', $userIntroduceMenber->id)->count();
                $pointSetting         = PointSetting::first();
                $points               = $pointSetting->introduce_member ?? self::DEFAULT_POINT_INTRODUCE_MEMBER;

                if ($totalIntroduceMember == 8) {
                    $points += $pointSetting->introduce_member_bonus ?? self::BONUS_POINT_INTRODUCE_MEMBER;
                }

                IntroduceMemberHistories::create([
                    'presenter_id' => $user->refer_user,
                    'user_id'      => $user->id,
                    'phone'        => $user->phone,
                    'point'        => $points
                ]);

                $userIntroduceMenber->point += $points;
                $userIntroduceMenber->save();
            });

            if ($userIntroduceMenber->token_fcm) {
                resolve(FCMService::class)->sendBySingleToken(
                    $userIntroduceMenber->token_fcm,
                    __('messages.notification.user.invite_member_title'),
                    __('messages.notification.introduce_member'),
                    []
                );
            }
        }

        return true;
    }
}
