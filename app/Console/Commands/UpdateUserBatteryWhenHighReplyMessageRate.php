<?php

namespace App\Console\Commands;

use App\Domains\User\Jobs\UserBatteryPointJob;
use App\Enum\UserActionableType;
use App\Models\UserChats;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUserBatteryWhenHighReplyMessageRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-user-battery-when-high-reply-message-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update User battery point when high reply message rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userChats = UserChats::query()
            ->selectRaw('user_target_id')
            ->groupBy('user_target_id')
            ->whereRaw('is_from_product IS TRUE')
            ->havingRaw('(count(case when user_reply then 1 end) / count(id)::decimal) > 0.7')
            ->get();
        $type = UserActionableType::GOOD_REPLY_MESSAGE;

        foreach ($userChats as $userChat) {
            (new UserBatteryPointJob($userChat->user_target_id, $type))->handle();
        }
        $now = Carbon::now();
        $userChatInMonth = UserChats::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->get('id')->pluck('id');

        UserChats::whereIn('id', $userChatInMonth)->delete();
    }
}
