<?php


namespace App\Repositories;


use App\Models\Token2fa;
use App\Repositories\Interfaces\Token2FARepositoryInterface;

class Token2FARepository implements Token2FARepositoryInterface
{
    protected $token2FA;

    public function __construct(Token2fa $token2FA)
    {
        $this->token2FA = $token2FA;
    }


    public function all($n)
    {
        return $this->token2FA->paginate($n);
    }

    public function getById($id)
    {
        return $this->token2FA->findOrFail($id);
    }

    public function user($id){
        return $this->getById($id)->user;
    }
}
