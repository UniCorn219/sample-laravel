<?php

namespace App\Domains\Promotion\Jobs;

use App\Criteria\PromotionCriteria;
use App\Models\Promotion;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Lucid\Units\Job;

class GetListPromotionJob extends Job
{
    private array $param;
    private array $with = [
        'areas',
        'categories',
    ];
    private array $select = ['*'];

    /**
     * Create a new job instance.
     *
     * @param  array  $param
     * @param  array  $with
     * @param  array  $select
     */
    public function __construct(array $param, array $with = [], array $select = [])
    {
        $this->param  = $param;
        $this->with   = $with ?: $this->with;
        $this->select = $select ?: $this->select;
    }

    /**
     * Execute the job.
     */
    public function handle(): Paginator|CursorPaginator
    {
        $query = Promotion::query();
        (new PromotionCriteria($this->param))->apply($query);
        $query->with($this->with)
            ->select($this->select);

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->orderByDesc('id')->cursorPaginate($limit);
    }
}
