<?php


namespace App\Repositories\Interfaces;


interface WorkerRepositoryInterface extends RepositoryInterface
{
    public function emails(int $id);

    public function phones(int $id);

    public function position(int $id);

    public function status(int $id);

    public function company(int $id);

    public function projects(int $id);

}
