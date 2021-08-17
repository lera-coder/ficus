<?php


namespace App;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTGuard;

class CustomJWTGuard extends JWTGuard
{
    use CustomTrait;

    /**
     * Overridden function to validate data to login
     * Now user can enter in login field login or email
     *
     * @param $user
     * @param $credentials
     * @return bool
     */
    public function validateCredentials($user, $credentials){

        if(str_contains($credentials['login'], '@')){
            if($user->activeEmail()->email != $credentials['login']) return false;
        }
        else{
            if($user->login != $credentials['login']) return false;
        }

        return Hash::check( $credentials['password'], $user->password);
    }


    /**
     * Attempt function for auth2fa
     *
     * @param $credentials
     * @return false|mixed
     */
    public function attempt2FA($credentials){
        $user = $this->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            return $user;
        }

        return false;
    }








}
