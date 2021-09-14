<?php


namespace App\Repositories\Interfaces;

interface WorkerStatusRepositoryInterface extends RepositoryInterface
{
    public function workers(int $id);
}
