<?php


namespace App;

use App\Models\Email;
use App\Models\User;

trait CustomTrait
{
    /**
     * Function to retrieve user.
     * Login and password are unique, so it's normal to use these fields to identify
     *
     * @param $credentials
     * @return mixed
     */
    public function retrieveByCredentials($credentials){
        return (str_contains($credentials['login'], '@') ?
            Email::where('email', $credentials['login'])->first()->user :
            User::where('login', $credentials['login'])->first());
    }

}
