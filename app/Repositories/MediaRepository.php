<?php

namespace App\Repositories;

use App\Models\Media;
use App\Repositories\Core\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MediaRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Media::class;
    }


    /**
     * Specify Query Builder
     *
     * @return Builder
     */
    public function query()
    {
        return Media::query();
    }
}
