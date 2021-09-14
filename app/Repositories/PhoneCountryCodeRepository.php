<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\PhoneCountryCode;
use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PhoneCountryCodeRepository implements PhoneCountryCodeRepositoryInterface
{
    public PhoneCountryCode $model;


    public function __construct(PhoneCountryCode $phone_country_code)
    {
        return $this->model = $phone_country_code;
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
    public function phones(int $id)
    {
        return $this->getById($id)->phones;
    }

    /**
     * @param int $id
     * @return PhoneCountryCode
     * @throws ModelNotFoundException
     */
    public function getById(int $id): PhoneCountryCode
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function users(int $id):Collection
    {
        return $this->getById($id)->users;
    }

    /**
     * @param $code
     * @return PhoneCountryCode
     */
    public function getIdByCode($code): PhoneCountryCode
    {
        return $this->model->where('code', $code)->first();
    }
}
