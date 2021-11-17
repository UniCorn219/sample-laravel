<?php

namespace App\Domains\Category\Jobs;

use App\Criteria\CategoryCriteria;
use App\Models\Category;
use App\Models\CategoryFavourite;
use Lucid\Units\Job;

class ListJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $query = Category::query();
        (new CategoryCriteria($this->param))->apply($query);

        return $query->get();
    }
}
