<?php


namespace App\Repositories\Interfaces;


interface EmailRepositoryInterface extends RepositoryInterface
{

    public function activeEmail(int $user_id);

    public function user(int $id);

    public function getModelByEmail(string $email_address);

}
