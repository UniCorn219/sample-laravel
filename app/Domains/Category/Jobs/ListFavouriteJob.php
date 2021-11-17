<?php

namespace App\Domains\Category\Jobs;

use App\Models\CategoryFavourite;
use Lucid\Units\Job;

class ListFavouriteJob extends Job
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
        return CategoryFavourite::where('user_id', $this->param['user_id'])->get();
    }
}
