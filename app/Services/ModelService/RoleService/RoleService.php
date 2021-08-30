<?php


namespace App\Services\ModelService\RoleService;


use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService implements RoleServiceInterface
{

    protected $role_repository;

    public function __construct(RoleRepositoryInterface $role_repository)
    {
        $this->role_repository = $role_repository;
    }

    public function update($id, $data)
    {
        return $this->role_repository->getById($id);
    }

    public function destroy($id)
    {
        return $this->role_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->role_repository->role->create($data);
    }
}
