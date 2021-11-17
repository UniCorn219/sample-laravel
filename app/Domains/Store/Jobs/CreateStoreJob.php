<?php

namespace App\Domains\Store\Jobs;

use App\Enum\DynamicLinkObject;
use App\Exceptions\MaxStoreReachedException;
use App\Models\Store;
use App\Services\Firebase\DynamicLinkService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Throwable;

class CreateStoreJob extends Job
{
    private int $currentUserId;
    private array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $currentUserId, array $data)
    {
        $this->currentUserId = $currentUserId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return Model|Store
     * @throws Throwable
     */
    public function handle(): Model|Store
    {
        $payload = $this->data;
        $payload['owner_id'] = $this->currentUserId;

        if (isset($payload['location'])) {
            $location = str_replace(',', ' ', $payload['location']);
            $payload['location'] = "POINT($location)";
        }

        $store = DB::transaction(function () use ($payload) {
            $stores = Store::useWritePdo()->where('owner_id', $payload['owner_id'])->lockForUpdate()->get();
            throw_if($stores->count() >= config('constant.max_store_own'), MaxStoreReachedException::class);

            $store = Store::create($payload);
            $store->save();
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::STORE, $store->id);
            $store->link_share = $dynamicLinks['shortLink'];
            $store->save();
            return $store;
        });

        return $store->refresh();
    }
}
