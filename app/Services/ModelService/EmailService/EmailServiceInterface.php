<?php


namespace App\Services\ModelService\EmailService;


use App\Models\User;
use App\Services\ModelService\ModelServiceInterface;

interface EmailServiceInterface extends ModelServiceInterface
{

    public function makeActive($id);




}
