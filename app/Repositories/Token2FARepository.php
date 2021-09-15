<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Token2fa;
use App\Repositories\Interfaces\Token2FARepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Token2FARepository implements Token2FARepositoryInterface
{
    protected $model;

    public function __construct(Token2fa $token2FA)
    {
        $this->model = $token2FA;
    }


    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function user(int $id)
    {
        return $this->getById($id)->user;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }
}
