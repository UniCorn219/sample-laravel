<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Illuminate\Support\Collection;
use Lucid\Units\Job;

class GetMenuJob extends Job
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
     * @return array|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function handle(): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return MenuStore::where('store_id', $this->id)
            ->with('image')
            ->orderBy('order')
            ->get();
    }
}
