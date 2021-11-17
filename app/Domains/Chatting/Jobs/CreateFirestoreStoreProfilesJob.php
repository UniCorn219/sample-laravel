<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\StoreProfile;
use App\Models\Store;
use Lucid\Units\Job;

class CreateFirestoreStoreProfilesJob extends Job
{
    private Store $store;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        $data = [
            'store_id' => $this->store->id,
            'name'     => $this->store->name,
            'phone'    => $this->store->phone,
            'avatar'   => $this->store->avatar_url,
            'address'  => $this->store->address,
        ];

        return StoreProfile::query()->insertGetId($data);
    }
}
