<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\GetStoreThreadJob;
use App\Domains\Chatting\Jobs\Thread\GetUserThreadJob;
use App\Domains\Chatting\Jobs\UpdateStoreThreadJob;
use App\Domains\Chatting\Jobs\UpdateUserThreadJob;
use App\Domains\Chatting\Requests\SettingNotificationRequest;
use App\Models\Store;
use App\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SettingNotificationFeature extends BaseFeatures
{
    /**
     * @var string id
     */
    private string $id;

    /**
     * SettingNotificationFeature constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function handle(SettingNotificationRequest $request): JsonResponse
    {
        $canNotify = $request->get('can_notify');
        $storeId = $request->get('store_id', null);

        $result = is_null($storeId) ?
            $this->settingNotifyUser($canNotify) :
            $this->settingNotifyStore($canNotify, $storeId);

        return $this->responseOk($result);
    }

    private function settingNotifyUser($canNotify)
    {
        $user = Auth::user();

        $userThread = $this->run(GetUserThreadJob::class, [
            'threadFuid' => $this->id,
            'userFuid'   => $user->firebase_uid,
        ]);

        return $this->run(UpdateUserThreadJob::class, [
            'values' => [
                'settings.can_notify' => $canNotify,
            ],
            'docId'  => $userThread->id,
        ]);
    }

    private function settingNotifyStore($canNotify, $storeId)
    {
        $user = Auth::user();
        $store = Store::query()->where([
            'owner_id' => $user->id,
            'id'       => $storeId,
        ])->firstOrFail();

        $storeThread = $this->run(GetStoreThreadJob::class, [
            'threadFuid' => $this->id,
            'storeFuid' => $store->firebase_uid,
        ]);

        return $this->run(UpdateStoreThreadJob::class, [
            'values' => [
                'settings.can_notify' => $canNotify,
            ],
            'docId'  => $storeThread->id,
        ]);
    }
}
