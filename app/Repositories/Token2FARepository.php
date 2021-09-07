<?php


namespace App\Repositories;


use App\Models\Token2fa;
use App\Repositories\Interfaces\Token2FARepositoryInterface;

class Token2FARepository implements Token2FARepositoryInterface
{
    protected $model;

    public function __construct(Token2fa $token2FA)
    {
        $this->model = $token2FA;
    }


    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function user($id)
    {
        return $this->getById($id)->user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
