<?php


namespace App\Repositories\Interfaces;


interface EmailRepositoryInterface extends RepositoryInterface
{

    public function activeEmail($user_id);

    public function user($id);

    public function getModelByEmail($email);

}
