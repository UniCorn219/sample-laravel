<?php

namespace App\Domains\User\Jobs;

use App\Models\EmdArea;
use Lucid\Units\Job;

class SearchEmdAreaByLongLatJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array  $param
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
        $location = explode(',', $this->param['location']);
        return EmdArea::whereRaw(
            "ST_Contains(geom::geometry, ST_SetSRID(ST_MakePoint(?, ?),4326))",
            [$location[0], $location[1]]
        )
            ->first();
    }
}
