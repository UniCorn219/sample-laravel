<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\CreateFirestoreStoreProfilesJob;
use App\Models\Firestore\StoreProfile;
use App\Models\Store;
use Lucid\Units\Operation;

class GetStoreFuidOperation extends Operation
{
    private Store $store;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($store->firebase_uid)) {
            $firestoreStore = $this->findStoreInFirestore();

            if (is_null($firestoreStore)) {
                $docId = $this->run(CreateFirestoreStoreProfilesJob::class, [
                    'store' => $this->store,
                ]);
            } else {
                $docId = $firestoreStore->id;
            }

            $this->store->firebase_uid = $docId;
            $this->store->save();
        }

        return $this->store->firebase_uid;
    }

    public function findStoreInFirestore()
    {
        return StoreProfile::findById($this->store->id);
    }
}
