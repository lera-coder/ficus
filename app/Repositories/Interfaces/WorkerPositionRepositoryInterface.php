<?php


namespace App\Repositories\Interfaces;


use App\Models\WorkerPosition;

interface WorkerPositionRepositoryInterface extends RepositoryInterface
{
    public function workers($id);

}
