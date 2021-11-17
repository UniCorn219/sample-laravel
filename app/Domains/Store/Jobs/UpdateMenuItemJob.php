<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class UpdateMenuItemJob extends Job
{
    private int   $id;
    private array $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, array $param)
    {
        $this->id    = $id;
        $this->param = $param;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        MenuStore::where('id', $this->id)->update($this->param);
    }
}
