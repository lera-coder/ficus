<?php


namespace App\Repositories;


use App\Models\PhoneCountryCode;
use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;

class PhoneCountryCodeRepository implements PhoneCountryCodeRepositoryInterface
{
    public $phone_country_code;


    public function __construct(PhoneCountryCode $phone_country_code)
    {
        return $this->phone_country_code = $phone_country_code;
    }


    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->phone_country_code->query()->paginate($n);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function phones($id)
    {
        return $this->getById($id)->phones;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->phone_country_code->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function users($id)
    {
        return $this->getById($id)->users;
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getIdByCode($code)
    {
        return $this->phone_country_code->query()->where('code', $code)->first();
    }
}
