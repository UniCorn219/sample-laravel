<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Builder;
use App\Lib\Firestore\Model;
use Exception;

class StoreProfile extends Model
{
    protected string $collectionName = 'store_profiles';

    /**
     * @param $storeId
     * @return Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|Model|object|null
     * @throws Exception
     */
    public static function findById($storeId)
    {
        return (new static)->newQuery()->where('store_id', $storeId)->first();
    }
}
