<?php


namespace App\Repositories\Interfaces;


interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function company(int $id);

    public function status(int $id);

    public function worker(int $id);

    public function technologies(int $id);

}
