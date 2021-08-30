<?php


namespace App\Repositories\Interfaces;


use App\Models\Email;

interface EmailRepositoryInterface extends RepositoryInterface
{

    public function activeEmail($user_id);

    public static function user(Email $email);

    public function getModelByEmail($email);

}
