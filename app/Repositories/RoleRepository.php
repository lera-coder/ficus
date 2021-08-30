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

    public function all($n)
    {
        return $this->role->paginate($n);
    }

    public function getById($id)
    {
        return $this->role->findOrFail($id);
    }

    public function users($id){
       return $this->getById($id)->users;
    }
}
