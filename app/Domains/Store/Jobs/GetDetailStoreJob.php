<?php

namespace App\Domains\Store\Jobs;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetDetailStoreJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $storeId)
    {
        $this->id = $storeId;
    }

    /**
     * Execute the job.
     *
     * @return Store
     * @throws \Throwable
     */
    public function handle(): Store
    {
        Store::findOrFail($this->id);
        DB::transaction(function () {
            /* @var Store $store*/
            $store = Store::useWritePdo()
                ->where('id', $this->id)
                ->lockForUpdate()
                ->first();
            $store->total_view += 1;
            $store->last_visited_at = Carbon::now();
            $store->save();
        });

        return Store::whereId($this->id)->with(['menus.image', 'images', 'category'])->first();
    }
}
