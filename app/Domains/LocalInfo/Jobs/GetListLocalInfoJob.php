<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Criteria\LocalInfoCriteria;
use App\Models\LocalInfo;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListLocalInfoJob extends Job
{
    private array $param;
    private array $with = [
        'emdArea',
        'emdArea.siggArea',
        'emdArea.siggArea.sidoArea',
        'images',
        'category',
        'store.addressMap',
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
     *
     * @return CursorPaginator
     */
    public function handle(): CursorPaginator
    {
        $query = LocalInfo::has('store');
        (new LocalInfoCriteria($this->param))->apply($query);
        $query->with($this->with)
            ->select($this->select);

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->orderByDesc('id')->cursorPaginate($limit);
    }
}
