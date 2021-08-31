<?php


namespace App\Repositories;


use App\Models\UserPermission;
use App\Repositories\Interfaces\UserPermissionsRepositoryInterface;

class UserPermissionsRepository implements UserPermissionsRepositoryInterface
{

    public $permission;

    public function __construct(UserPermission $permission)
    {
        $this->permission = $permission;
    }

    public function all($n)
    {
        return $this->permission->query()->paginate($n);
    }

    public function getById($id)
    {
        return $this->permission->query()->findOrFail($id);
    }
}
