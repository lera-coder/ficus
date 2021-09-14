<?php


namespace App\Repositories\Interfaces;

interface WorkerPhoneRepositoryInterface extends RepositoryInterface
{
    public function worker(int $id);

}
