<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserActionableType;
use App\Models\User;
use App\Models\UserActionable;
use App\Models\UserBlocking;
use App\Models\UserChats;
use App\Models\UserNicknameChange;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;
use App\Services\Firebase\DynamicLinkService;
use App\Enum\DynamicLinkObject;

class GetUserInfo extends Job
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
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::with('address')->select([
            'id',
            'name',
            'avatar',
            'battery_point',
            'battery_level',
            'total_point',
            'nickname',
            'birth',
            'link_share',
            'gender'
        ])
            ->where('id', $this->param['user_id'])
            ->first();
        if ($user && empty($user->link_share)) {
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::USER, $user->id);
            $user->update(['link_share' => $dynamicLinks['shortLink']]);
            $user = $user->refresh();
        }

        // Get response rate chatting
        $now = Carbon::now();
        $timeAgo = Carbon::now()->subDays(90);
        $responseRateChatting = UserChats::query()
            ->selectRaw('(sum(case when user_reply then 1 end) / count(id)::decimal) as response_rate')
            ->where('user_target_id', $this->param['user_id'])
            ->whereBetween('created_at', [$timeAgo, $now])
            ->first();
        $responseRate = (isset($responseRateChatting->response_rate) && empty($responseRateChatting->response_rate)) ? 0 : round($responseRateChatting->response_rate, 2);

        // Get blocking
        $condition = [
            'user_id'        => Auth::user()->id ?? 0,
            'user_target_id' => $this->param['user_id'],
        ];
        $blocking  = UserBlocking::where($condition)->first();

        // Get following
        $condition = [
            'user_id'     => Auth::user()->id ?? 0,
            'target_id'   => $this->param['user_id'],
            'target_type' => UserActionableType::ENTITY_USER,
            'action_type' => UserActionableType::ACTION_USER_FOLLOW,
        ];
        $following = UserActionable::where($condition)->first();

        // Get allow change nickname
        $userNickName = UserNicknameChange::query()->where('user_id', $user->id)->orderByDesc('id')->first();
        $now          = Carbon::now()->format('Y-m');

        $user->is_blocked            = !empty($blocking);
        $user->is_followed           = !empty($following);
        $user->allow_change_nickname = !(!empty($userNickName) && ($now === Carbon::parse($userNickName->created_at)->format('Y-m')));
        $user->response_rate         = ($responseRate > 1) ? 1 : $responseRate;

        return $user;
    }
}
