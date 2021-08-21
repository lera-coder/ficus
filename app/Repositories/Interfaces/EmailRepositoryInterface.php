<?php


namespace App\Repositories\Interfaces;


interface EmailRepositoryInterface extends RepositoryInterface
{

    public function activeEmail($user_id);

}
