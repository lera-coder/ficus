<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all users
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->user->paginate($n);
    }


    /**
     * Get 1 user by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }


    /**
     * get all emails from 1 user
     * @param User $user
     * @return mixed
     */
    public function emails($id)
    {
        return $this->getById($id)->get->emails;
    }

    /**
     * Get all phones by user model
     * @param User $user
     * @return mixed
     */
    public function phones($id)
    {
        return $this->getById($id)->phones;
    }

    /**
     * Get active phone by user model
     * @param User $user
     * @return mixed
     */
    public function activePhone($id)
    {
        return $this->phones($id)->where('is_active', 1)->first();
    }

    /**
     * Get disactive phones by user model
     * @param User $user
     * @return mixed
     */
    public function disactivePhones($id)
    {
        return $this->phones($id)->where('is_active', 0);
    }

    /**
     * Get full version of active phone (with country code)
     * @param User $user
     * @return string
     */
    public function getFullActivePhone($id)
    {
        return $this->getActivePhoneCountryCode($id)->code.$this->activePhone($id)->phone_number;
    }

    /**
     * Get network, via those user is logged in
     * @param User $user
     * @return mixed
     */
    public function network($id)
    {
        return $this->getById($id)->network;
    }


    /**
     * Get token2fa model of user
     * @param User $user
     * @return mixed
     */
    public function token2fa($id)
    {
        return $this->getById($id)->token2fa;
    }


    /**
     * Get country code of active phone
     * @param User $user
     * @return mixed
     */
    protected function getActivePhoneCountryCode($id)
    {
        return $this->activePhone($id)->phoneCountryCode;
    }

    /**
     * Get all roles of user
     * @param User $user
     * @return mixed
     */
    public function roles($id)
    {
        return $this->getById($id)->roles;
    }

    /**
     * get id primary key with login
     * @param $login
     * @return mixed
     */
    public function getIdViaLogin($login){
        return $this->user->where('login', $login)->first()->id;
    }

}
