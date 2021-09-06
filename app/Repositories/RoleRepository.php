<?php


namespace App\Repositories;


use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->role->paginate($n);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function users($id)
    {
        return $this->getById($id)->users;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->role->findOrFail($id);
    }
}
