<?php

namespace App\Repositories;

use App\Exceptions\ResourceNotFoundException;
use Exception;
use Throwable;
use App\Repositories\Core\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Query Builder
     *
     * @return Builder
     */
    public function query()
    {
        return User::query();
    }

    /**
     * Get paginator of resource descending by id.
     *
     * @return LengthAwarePaginator
     */
    public function getPaginator()
    {
        return $this->query()
            ->with([
                'position',
                'department'
            ])
            ->orderBy('id', 'DESC')
            ->paginate();
    }

    /**
     * Remove an existing user.
     *
     * @param $id
     * @return bool|mixed|null
     * @throws Exception
     * @throws Throwable
     */
    public function remove($id)
    {
        $model = $this->query()->find($id);
        throw_if(!$model, new ResourceNotFoundException());

        return $model->delete();
    }

    /**
     * Get user email.
     *
     * @param $email
     * @return Collection
     */
    public function findEmail($email)
    {
        return $this->query()
            ->withTrashed()
            ->where('email', $email)
            ->get();
    }
}
