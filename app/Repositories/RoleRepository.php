<?php


namespace App\Repositories;


use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->model->paginate($n);
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
        return $this->model->findOrFail($id);
    }
}
