<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Requests\CreateStoreThreadRequest;
use App\Models\Store;
use App\Models\User;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\CreateStoreThreadOperation;
use App\Services\Chatting\Operations\GetStoreFuidOperation;
use App\Services\Chatting\Operations\GetUserFuidOperation;
use Illuminate\Support\Facades\Auth;

class CreateStoreThreadFeature extends BaseFeatures
{
    public function handle(CreateStoreThreadRequest $request)
    {
        $user = Auth::user();

        $localInfoId = $request->get('localinfo_id');
        $storeId     = $request->get('store_id');

        // Get Store information
        $store      = Store::query()->findOrFail($storeId);
        $storeOwner = User::query()->findOrFail($store->owner_id);

        $userFuid       = $this->run(GetUserFuidOperation::class, ['userId' => $user->id]);
        $storeOwnerFuid = $this->run(GetUserFuidOperation::class, ['userId' => $storeOwner->id]);
        $storeFuid      = $this->run(GetStoreFuidOperation::class, ['store' => $store]);

        $thread = $this->run(CreateStoreThreadOperation::class, [
            'userFuid'       => $userFuid,
            'storeFuid'      => $storeFuid,
            'localInfoId'    => $localInfoId,
            'storeOwnerFuid' => $storeOwnerFuid,
            'storeId'        => $store->id,
        ]);

        return $this->responseOk($thread);
    }
}
