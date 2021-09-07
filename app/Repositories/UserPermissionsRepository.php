<?php


namespace App\Repositories;


use App\Models\UserPermission;
use App\Repositories\Interfaces\UserPermissionsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserPermissionsRepository implements UserPermissionsRepositoryInterface
{

    public $model;

    public function __construct(UserPermission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
