<?php

namespace App\Domains\Notification\Jobs;

use App\Models\Notification;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Throwable;

class StoreNotificationJob extends Job
{
    protected int         $entityId;
    protected int         $entityType;
    protected int|null    $entityActionId;
    protected int|null    $entityActionType;
    protected int         $actorId;
    protected int         $receiveId;
    protected mixed       $actionType;
    protected string|null $keyword;
    protected string|null $amount;

    public function __construct($entityType, $entityId, $actorId, $receiveId, $actionType = null, $entityActionType = null, $entityActionId = null, $keyword = null, $amount = null)
    {
        $this->entityId         = $entityId;
        $this->entityType       = $entityType;
        $this->entityActionId   = $entityActionId;
        $this->entityActionType = $entityActionType;
        $this->actorId          = $actorId;
        $this->receiveId        = $receiveId;
        $this->actionType       = $actionType;
        $this->keyword          = $keyword;
        $this->amount           = $amount;
    }

    /**
     * @throws Throwable
     */
    public function handle(): bool|int
    {
        try {
            DB::beginTransaction();
            $idNotificationObject = NotificationObject::query()->insertGetId([
                'entity_type'        => $this->entityType,
                'entity_id'          => $this->entityId,
                'entity_action_type' => $this->entityActionType,
                'entity_action_id'   => $this->entityActionId,
                'action_type'        => $this->actionType,
                'status'             => true,
                'keyword'            => $this->keyword,
                'amount'             => $this->amount,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ]);

            $notificationId = Notification::query()->insertGetId([
                'notification_object_id' => $idNotificationObject,
                'receive_id'             => $this->receiveId,
                'is_seen'                => false,
                'is_read'                => false,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now(),
            ]);

            NotificationChange::insert([
                'notification_object_id' => $idNotificationObject,
                'actor_id'               => $this->actorId,
                'status'                 => true,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now(),
            ]);
            DB::commit();

            return $notificationId;
        } catch (\Exception) {
            DB::rollBack();

            return false;
        }
    }
}
