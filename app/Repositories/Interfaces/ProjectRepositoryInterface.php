<?php


namespace App\Repositories\Interfaces;


interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function company($id);

    public function status($id);

    public function worker($id);

    public function technologies($id);

}
