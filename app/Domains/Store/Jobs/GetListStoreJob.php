<?php

namespace App\Domains\Store\Jobs;

use App\Criteria\StoreCriteria;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetListStoreJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return array|Collection
     */
    public function handle(): array|Collection
    {
        $query = Store::query()->select('*');

        (new StoreCriteria($this->param))->apply($query);

        return $query->orderBy('created_at')->get();
    }
}
