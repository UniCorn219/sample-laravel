<?php

namespace App\Domains\Category\Jobs;

use App\Models\CategoryFavourite;
use Lucid\Units\Job;

class SaveFavouriteJob extends Job
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
        CategoryFavourite::where('user_id', $this->param['user_id'])->delete();
        if (!empty($this->param['category_id'])) {
            $insert = collect($this->param['category_id'])->map(function ($id) {
                return [
                    'user_id' => $this->param['user_id'],
                    'category_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
            CategoryFavourite::insert($insert->toArray());
        }
    }
}
