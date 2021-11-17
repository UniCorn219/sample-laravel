<?php

namespace App\Domains\User\Jobs;

use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetUserAddressDetailJob extends Job
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
    public function handle(): UserAddress|null
    {
        return UserAddress::where('user_id', $this->param['user_id'])
            ->select([
                '*',
                DB::raw('ST_X(ST_Transform(location::geometry, 4326)) AS long'),
                DB::raw('ST_Y(ST_Transform(location::geometry, 4326)) AS lat'),
            ])
            ->first();
    }
}
