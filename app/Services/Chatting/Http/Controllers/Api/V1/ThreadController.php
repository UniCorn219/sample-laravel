<?php

namespace App\Services\Chatting\Http\Controllers\Api\V1;

use App\Services\Chatting\Features\ApproveOrderFeature;
use App\Services\Chatting\Features\BlockUserThreadFeature;
use App\Services\Chatting\Features\CreateMessageFeature;
use App\Services\Chatting\Features\CreatePayCoinFeature;
use App\Services\Chatting\Features\CreatePayCoinMessageFeature;
use App\Services\Chatting\Features\CreateReservationFeature;
use App\Services\Chatting\Features\CreateStoreThreadFeature;
use App\Services\Chatting\Features\CreateThreadFeature;
use App\Services\Chatting\Features\DeleteReservationFeature;
use App\Services\Chatting\Features\DeleteThreadFeature;
use App\Services\Chatting\Features\GetAllStickersFeature;
use App\Services\Chatting\Features\SettingNotificationFeature;
use App\Services\Chatting\Features\UnblockUserThreadFeature;
use App\Services\Chatting\Features\UpdateReservationFeature;
use Lucid\Units\Controller;

class ThreadController extends Controller
{
    public function create(): mixed
    {
        return $this->serve(CreateThreadFeature::class);
    }

    public function createMessage($threadFuid): mixed
    {
        return $this->serve(CreateMessageFeature::class, [
            'threadFuid' => $threadFuid,
        ]);
    }

    public function destroy($threadFuid): mixed
    {
        return $this->serve(DeleteThreadFeature::class, [
            'threadFuid' => $threadFuid,
        ]);
    }

    public function createReservation($id): mixed
    {
        return $this->serve(CreateReservationFeature::class, ['id' => $id]);
    }

    public function updateReservation($threadId, $reservationId): mixed
    {
        return $this->serve(UpdateReservationFeature::class, [
            'threadId'      => $threadId,
            'reservationId' => (int)$reservationId,
        ]);
    }

    public function destroyReservation($id, $reserID): mixed
    {
        return $this->serve(DeleteReservationFeature::class, ['param' => ['id' => $id, 'reserId' => $reserID]]);
    }

    public function settingNotification($id): mixed
    {
        return $this->serve(SettingNotificationFeature::class, ['id' => $id]);
    }

    public function createStoreThread()
    {
        return $this->serve(CreateStoreThreadFeature::class);
    }

    public function blockThread($threadFuid): mixed
    {
        return $this->serve(BlockUserThreadFeature::class, [
            'threadFuid' => $threadFuid,
        ]);
    }

    public function unblockThread($threadFuid): mixed
    {
        return $this->serve(UnblockUserThreadFeature::class, [
            'threadFuid' => $threadFuid,
        ]);
    }

    public function createPayCoinMsg()
    {
        return $this->serve(CreatePayCoinFeature::class);
    }

    public function getStickers()
    {
        return $this->serve(GetAllStickersFeature::class);
    }
}
