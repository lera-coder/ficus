<?php


namespace App\Repositories\Interfaces;


interface RepositoryInterface
{
    public function all($n);

    public function getById($id);

}
