<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Area;
use Illuminate\Support\Collection;
use Lucid\Units\Job;

class SearchAreaJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle(): \Illuminate\Database\Eloquent\Collection|array|Collection
    {
        $search = $this->param['search'];
        $parent = Area::where('name', 'like', "%$search%")
            ->orderBy('level')
            ->first();

        if (!$parent) {
            return collect([]);
        }

        if ($parent->level == 3) {
            return collect([$parent]);
        }

        return Area::where('level', $parent->level + 1)
            ->where('original_parent_area_id', $parent->original_area_id)
            ->get();
    }
}
