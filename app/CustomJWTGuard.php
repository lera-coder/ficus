<?php


namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTGuard;

class CustomJWTGuard extends JWTGuard
{

    /**
     * Overridden function to validate data to login
     * Now user can enter in login field login or email
     *
     * @param $user
     * @param $credentials
     * @return bool
     */
    protected function validateCredentials($user, $credentials){

        if(str_contains($credentials['login'], '@')){
            if(!$this->ValidateLogin($credentials['login'], 'email')) return false;
        }
        else{
            if(!$this->ValidateLogin($credentials['login'], 'login')) return false;
        }

        return Hash::check( $credentials['password'], $user->password);
    }


    /**
     * Function to retrieve user.
     * Login and password are unique, so it's normal to use these fields to identify
     *
     * @param $credentials
     * @return mixed
     */
    public function retrieveByCredentials($credentials){
        return (str_contains($credentials['login'], '@') ?
            User::where('email', $credentials['login'])->first() :
            User::where('login', $credentials['login'])->first());
    }


    /**
     * Private function to check availability of login in database
     *
     * @param $login
     * @param $key
     * @return mixed
     */
    private function ValidateLogin($login, $key){
        return User::where($key, $login)->first();

    }


}
