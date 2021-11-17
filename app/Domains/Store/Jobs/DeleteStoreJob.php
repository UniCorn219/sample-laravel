<?php

namespace App\Domains\Store\Jobs;

use App\Enum\UserActionableType;
use App\Enum\UserReviewableType;
use App\Models\LocalInfo;
use App\Models\Mediable;
use App\Models\MenuStore;
use App\Models\Promotion;
use App\Models\Store;
use App\Models\UserActionable;
use App\Models\UserReviewable;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class DeleteStoreJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     * @throws Throwable
     */
    public function handle(): bool
    {
        $store = Store::find($this->id);

        $localInfos = LocalInfo::where('store_id', $store->id)->get('id');
        $localInfoIds = $localInfos->pluck('id');

        DB::beginTransaction();

        try {
            Promotion::whereIn('localinfo_id', $localInfoIds)->delete();
            UserReviewable::where(['target_id' => $this->id, 'review_type' => UserReviewableType::STORE])->delete();
            MenuStore::where('store_id', $this->id)->delete();
            Mediable::where(['target_id' => $this->id, 'type' => Mediable::TYPE['STORE']])->delete();
            UserActionable::where(['target_id' => $this->id, 'target_type' => UserActionableType::ENTITY_STORE,])->delete();
            LocalInfo::whereIn('id', $localInfoIds)->delete();
            $store->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
}
