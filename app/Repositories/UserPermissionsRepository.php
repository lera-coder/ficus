<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\UserPermission;
use App\Repositories\Interfaces\UserPermissionsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserPermissionsRepository implements UserPermissionsRepositoryInterface
{

    public UserPermission $model;

    public function __construct(UserPermission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }
}
