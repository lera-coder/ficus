<?php


namespace App\Repositories\Interfaces;


interface ProjectStatusRepositoryInterface extends RepositoryInterface
{
    public function projects(int $id);

}
