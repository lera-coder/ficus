<?php


namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function users(int $id);
}
