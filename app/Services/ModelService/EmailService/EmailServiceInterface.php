<?php


namespace App\Services\ModelService\EmailService;


use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\ModelServiceInterface;

interface EmailServiceInterface extends ModelServiceInterface
{

    public function makeActive($email_id, $user_id);

    public function create($credentials, $user_id);


}
