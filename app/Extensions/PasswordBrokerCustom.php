<?php

namespace App\Extensions;

use App\Models\Email;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Arr;

class PasswordBrokerCustom extends PasswordBroker
{
    use CustomTrait;


    /**
     * Override method of Password Broker get User
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|mixed|null
     */
    public function getUser(array $credentials)
    {
        $credentials = Arr::except($credentials, ['token']);
        return $this->retrieveByCredentials($credentials);
    }



    /**
     * Override method of class PasswordBroker to validate data after going by link
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|string|null
     */
    protected function validateReset(array $credentials)

    {
        if (is_null($user = Email::where('email', $credentials['email'])->first()->user)) {
            return static::INVALID_USER;
        }

        if (! $this->tokens->exists($user, $credentials['token'])) {
            return static::INVALID_TOKEN;
        }
        return $user;

    }







}
