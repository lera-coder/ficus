<?php


namespace App\Services\ModelService\UserService;


use App\Models\User;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use App\Services\ModelService\ModelServiceInterface;

interface UserServiceInterface extends ModelServiceInterface
{

    public function toggle2FA();

    public function check2FAtoken($token);

    public function set2FAtoken();

    public function updateUserAfterSocialNetworkLoggedIn($network, $user_credentials);

    public function getEmailViaLogin($login);

    public function send2FACode();

    public function returnResetPasswordStatus($reset_password_data);

    public function makeApplicantUser($applicant_data, $request_data);




}
