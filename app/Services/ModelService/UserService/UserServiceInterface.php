<?php


namespace App\Services\ModelService\UserService;


use App\Services\ModelService\ModelServiceInterface;

interface UserServiceInterface extends ModelServiceInterface
{


//    public function makeEmailActive($email_id);

//    public function addEmail($email);

//    public function makePhoneActive($phone_id);

//    public function addPhone($phone);

    public function toggle2FA($id);

    public function check2FAtoken($token, $id);

    public function set2FAtoken($id);

    public function updateUserAfterSocialNetworkLoggedIn($network_id, $user_id);

    public function getEmailViaLogin($login);

    public function create($credentials);



}
