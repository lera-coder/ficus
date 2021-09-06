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

    public $permission;

    public function __construct(UserPermission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->permission->query()->paginate($n);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->permission->query()->findOrFail($id);
    }
}
