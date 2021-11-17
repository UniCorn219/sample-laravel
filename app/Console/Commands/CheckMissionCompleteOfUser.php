<?php

namespace App\Console\Commands;

use App\Domains\Notification\Jobs\PushAndSaveNotificationFinishMissionJobQueue;
use App\Domains\User\Jobs\UserBatteryPointJob;
use App\Enum\UserActionableType;
use App\Models\Mission;
use App\Models\UserMission;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Lucid\Bus\UnitDispatcher;
use ReflectionClass;

class CheckMissionCompleteOfUser extends Command
{
    use UnitDispatcher;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check mission of user complete or not';

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
     * @return boolean
     * @throws \Throwable
     */
    public function handle(): bool
    {
        $users     = DB::table('users')->select(['id', 'created_at'])->whereNull('deleted_at')->get();
        $now       = Carbon::now();
        $missionId = Mission::MISSION_7_ID;

        foreach ($users as $user) {
            $date = Carbon::parse($user->created_at);
            $year = $now->diffInYears($date);

            if ($year >= 1) {
                // Mission 7
                $userMission = UserMission::where(['user_id' => $user->id, 'mission_id' => $missionId])->first();
                if (!$userMission) {
                    $newUserMission = UserMission::create(['user_id' => $user->id, 'mission_id' => $missionId]);
                    (new UserBatteryPointJob($user->id, UserActionableType::USED_APP_1_YEAR, 100000))->handle();

                    $this->runInQueue(PushAndSaveNotificationFinishMissionJobQueue::class, ['userMission' => $newUserMission]);
                }
            }
        }

        return true;
    }

    public function runInQueue($unit, array $arguments = [], $queue = '')
    {
        $connection = config('queue.default');
        $queue      = $queue ?: config('queue.connections.' . $connection . '.queue');

        // instantiate and queue the unit
        $reflection = new ReflectionClass($unit);
        $instance   = $reflection->newInstanceArgs($arguments);
        $instance->onQueue((string)$queue);

        return $this->dispatch($instance);
    }
}
