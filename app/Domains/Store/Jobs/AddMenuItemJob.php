<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class AddMenuItemJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {
        $this->param   = $param;
    }

    /**
     * @return MenuStore|Model
     */
    public function handle(): Model|MenuStore
    {
        return MenuStore::create($this->param);
    }
}
