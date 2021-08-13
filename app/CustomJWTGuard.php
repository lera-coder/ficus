<?php


namespace App;

use App\Models\Email;
use App\Models\User;
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
    protected function validateCredentials($user, $credentials){

        if(str_contains($credentials['login'], '@')){
            if($user->activeEmail()->email != $credentials['login']) return false;
        }
        else{
            if($user->login != $credentials['login']) return false;
        }

        return Hash::check( $credentials['password'], $user->password);
    }


//    /**
//     * Function to retrieve user.
//     * Login and password are unique, so it's normal to use these fields to identify
//     *
//     * @param $credentials
//     * @return mixed
//     */
//    public function retrieveByCredentials($credentials){
//        return (str_contains($credentials['login'], '@') ?
//            Email::where('email', $credentials['login'])->first()->user :
//            User::where('login', $credentials['login'])->first());
//    }





}
