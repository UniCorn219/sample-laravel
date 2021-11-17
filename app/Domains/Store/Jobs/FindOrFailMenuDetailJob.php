<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;
use Throwable;

class FindOrFailMenuDetailJob extends Job
{
    private int   $id;
    private array $with;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, array $with = [])
    {
        $this->id   = $id;
        $this->with = $with;
    }

    /**
     * @return Store|Store[]|Collection|Model
     * @throws Throwable
     */
    public function handle(): array|Model|Collection|Store
    {
        $menu = MenuStore::findOrFail($this->id);

        if ($this->with) {
            return $menu->load($this->with);
        }

        return $menu;
    }
}
