<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Lucid\Units\Job;

class GetPrevAndNextOrderingJob extends Job
{
    private int  $id;
    private int $prevId;
    private int $nextId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, int|null $prevId, int|null $nextId)
    {
        $this->id     = $id;
        $this->prevId = (int)$prevId;
        $this->nextId = (int)$nextId;
    }

    /**
     * @return string[]
     */
    public function handle(): array
    {
        $menus = MenuStore::where('store_id', $this->id)
            ->whereIn('id', [$this->prevId, $this->nextId])
            ->get()
            ->keyBy('id');

        $prev = $menus[$this->prevId]->order ?? '';
        $next = $menus[$this->nextId]->order ?? '';

        return [$prev, $next];
    }
}
