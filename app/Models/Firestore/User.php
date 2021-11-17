<?php

namespace App\Models\Firestore;

use App\Lib\Firestore\Builder;
use App\Lib\Firestore\Model;
use Exception;

/**
 * Class User
 * @package App\Models\Firestore
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $avatar
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class User extends Model
{
    protected string $collectionName = 'users';

    protected array $fillable = ['name', 'phone', 'avatar'];

    /**
     * @param $userId
     * @return Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|Model|object|null
     * @throws Exception
     */
    public static function findById($userId)
    {
        return (new static)->newQuery()->where('user_id', $userId)->first();
    }
}
