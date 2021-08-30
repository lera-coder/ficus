<?php


namespace App\Repositories;


use App\Models\Phone;
use App\Repositories\Interfaces\PhoneRepositoryInterface;

class PhoneRepository implements PhoneRepositoryInterface
{

    public $phone;

    public function __construct(Phone $phone)
    {
        $this->phone = $phone;
    }

    public function activePhone($user_id)
    {
        return $this->phone->where('user_id', $user_id)->where('is_active', 1)->first();
    }

    public function all($n)
    {
        return $this->phone->paginate($n);
    }

    public function getById($id)
    {
        return $this->phone->findOrFail($id);
    }

    public function  user($id){
        return $this->getById($id)->user;
    }

    public function phoneCountryCode($id){
        return $this->getById($id)->phoneCountryCode;
    }
}