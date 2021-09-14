<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Phone;
use App\Models\PhoneCountryCode;
use App\Models\User;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PhoneRepository implements PhoneRepositoryInterface
{

    public Phone $model;

    public function __construct(Phone $phone)
    {
        $this->model = $phone;
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
     * @return Phone
     * @throws ModelNotFoundException
     */
    public function getById(int $id):Phone
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function user(int $id):User
    {
        return $this->getById($id)->query()->user;
    }


    /**
     * @param int $user_id
     * @return Phone
     */
    public function activePhone(int $user_id): Phone
    {
        return $this->model
            ->query()
            ->where('user_id', $user_id)
            ->active()
            ->first();
    }


    /**
     * @param int $id
     * @return PhoneCountryCode
     * @throws ModelNotFoundException
     */
    public function phoneCountryCode(int $id): PhoneCountryCode
    {
        return $this->getById($id)->query()->phoneCountryCode;
    }
}
