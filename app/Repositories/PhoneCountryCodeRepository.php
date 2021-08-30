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

    public function all($n)
    {
        return $this->phone_country_code->paginate($n);
    }

    public function getById($id)
    {
        return $this->phone_country_code->findOrFail($id);
    }

    public function phones($id){
        return $this->getById($id)->phones;
    }

    public function users($id){
        return $this->getById($id)->users;
    }

    public function getIdByCode($code){
        return $this->phone_country_code->where('code', $code)->first();
    }
}
