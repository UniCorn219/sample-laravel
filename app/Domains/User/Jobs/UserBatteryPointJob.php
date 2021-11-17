<?php

namespace App\Domains\User\Jobs;

use App\Domains\Notification\Jobs\PushAndSaveNotificationFinishMissionJobQueue;
use App\Domains\Notification\Jobs\PushAndSaveNotificationLevelUpJobQueue;
use App\Domains\Point\Jobs\UpdatePointJob;
use App\Enum\UserActionableType;
use App\Models\Mission;
use App\Models\User;
use App\Models\UserMission;
use App\ValueObjects\Amount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lucid\Bus\UnitDispatcher;
use Lucid\Units\Job;
use ReflectionClass;
use Throwable;

class UserBatteryPointJob extends Job
{
    use UnitDispatcher;

    private int      $userId;
    private int|null $point;
    private string   $type;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param string $type
     * @param int|null $point
     */
    public function __construct(int $userId, string $type, int $point = null)
    {
        $this->userId = $userId;
        $this->type   = $type;
        $this->point  = $point;
    }

    /**
     * Execute the job.
     *
     * @return Collection|Model|User|boolean
     * @throws Throwable
     */
    public function handle(): User|Collection|Model|bool
    {
        $user = User::find($this->userId);

        if (!$user || !isset(UserActionableType::USER_BATTERY[$this->type])) {
            return false;
        }

        $oldLevelBattery = $user->battery_level;

        if ($this->type === UserActionableType::USER_WAS_REPORTED_5_TIME_IN_A_ROW) {
            $user->battery_point = 0;
            $user->battery_level = 1;

            return $user->save();
        }

        $user->battery_point += UserActionableType::USER_BATTERY[$this->type];
        if ($this->point) {
            $point = new UpdatePointJob($this->userId, Amount::create($this->point), '');
            $point->handle();
            //$user->total_point += $this->point;
        }

        if ($this->type === UserActionableType::USER_WAS_REPORTED_THROTTLE || $user->battery_point < 0) {
            $user->battery_point = 0;
        }

        $batteryPoint        = $user->battery_point;
        $user->battery_level = match (true) {
            $batteryPoint >= 0 && $batteryPoint <= 200 => 1,
            $batteryPoint > 200 && $batteryPoint <= 400 => 2,
            $batteryPoint > 400 && $batteryPoint <= 600 => 3,
            $batteryPoint > 600 && $batteryPoint <= 800 => 4,
            $batteryPoint > 800 => 5,
        };

        $date = Carbon::parse($user->created_at);
        $diff = $date->diffInDays(Carbon::now());

        // Mission 3
        $userCompleteMission3 = UserMission::where(['user_id' => $user->id, 'mission_id' => Mission::MISSION_3_ID])->first();
        if ($user->battery_level === 5 && $diff <= 100 && !$userCompleteMission3) {
            $user->battery_point += 100;

            $point = new UpdatePointJob($this->userId, Amount::create(100000), '');
            $point->handle();
            //$user->total_point += 100000;

            $newUserMission = UserMission::create(['user_id' => $user->id, 'mission_id' => Mission::MISSION_3_ID]);
            $this->runInQueue(PushAndSaveNotificationFinishMissionJobQueue::class, ['userMission' => $newUserMission]);
        }

        $user->save();

        $newLevelBattery = $user->battery_level;
        if ($newLevelBattery > $oldLevelBattery) {
            $this->runInQueue(PushAndSaveNotificationLevelUpJobQueue::class, ['user' => $user]);
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
