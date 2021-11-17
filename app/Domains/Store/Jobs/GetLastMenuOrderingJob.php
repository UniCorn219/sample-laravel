<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Lucid\Units\Job;

class GetLastMenuOrderingJob extends Job
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
     * @return string
     */
    public function handle(): string
    {
        $last = MenuStore::where('store_id', $this->id)
            ->orderByDesc('order')
            ->first();

        return (string) ($last->order ?? '');
    }
}
