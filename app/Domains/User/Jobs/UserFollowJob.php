<?php

namespace App\Domains\User\Jobs;

use App\Domains\Notification\Jobs\StoreNotificationJob;
use App\Enum\EntityMorphType;
use App\Enum\NotificationAction;
use App\Enum\UserActionableType;
use App\Models\UserActionable;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

/**
 * @method run(string $class, array $array)
 */
class UserFollowJob extends Job
{
    private array      $data;
    private null|Model $resource;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data, null|Model $resource)
    {
        $this->data     = $data;
        $this->resource = $resource;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $data         = $this->data;
        $userId       = $data['user_id'];
        $userTargetId = $data['target_id'];

        $existedFollow = UserActionable::where($data)->first();
        $actionType    = $this->getActionType((int)$data['action_type']);

        if ($existedFollow) {
            $existedFollow->delete();

            if ($this->resource && $this->resource->{$actionType} > 0) {
                $this->resource->{$actionType} -= 1;
                $this->resource->save();
            }

            return false;
        } else {
            $follow = UserActionable::create($this->data);

            if ($this->resource) {
                $this->resource->{$actionType} += 1;
                $this->resource->save();
            }

            $this->saveNotification($follow, $userId, $userTargetId);

            return true;
        }
    }

    public function saveNotification($follow, $userId, $userTargetId)
    {
        $notification = new StoreNotificationJob(
            EntityMorphType::USER,
            $userTargetId,
            $userId,
            $userTargetId,
            NotificationAction::FOLLOW_USER,
            EntityMorphType::USER,
            $userId
        );

        try {
            $notification->handle();

            return true;
        } catch (\Throwable $e) {
            return true;
        }
    }

    private function getActionType(int $actionType): string
    {
        if ($actionType === UserActionableType::ACTION_USER_LIKE) {
            return 'total_like';
        } else {
            return 'total_follow';
        }
    }
}
