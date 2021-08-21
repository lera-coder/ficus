<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all($n)
    {
        return $this->user->paginate($n);
    }

    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }


    public function emails($id)
    {
        return $this->getById($id)->emails;
    }

    public function phones($id)
    {
        return $this->getById($id)->phones;
    }

    public function activePhone($id)
    {
        return $this->phones($id)->where('is_active', 1);
    }

    public function disactivePhones($id)
    {
        return $this->phones($id)->where('is_active', 0);
    }

    public function getFullActivePhone($id)
    {
        return $this->getActivePhoneCountryCode($id)->code.$this->activePhone($id)->phone_number;
    }

    public function network($id)
    {
        return $this->getById($id)->network;
    }


    public function token2fa($id)
    {
        return $this->getById($id)->token2fa;
    }


    public function getActivePhoneCountryCode($id)
    {
        return $this->activePhone($id)->phoneCountryCode;
    }

    public function roles($id)
    {
        return $this->getById($id)->roles;
    }

    public function getIdViaLogin($login){
        return $this->user->where('login', $login)->first()->id;
    }
}
