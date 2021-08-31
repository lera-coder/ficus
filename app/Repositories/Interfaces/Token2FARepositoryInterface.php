<?php


namespace App\Repositories\Interfaces;


interface Token2FARepositoryInterface extends RepositoryInterface
{
    public function user($id);

}
