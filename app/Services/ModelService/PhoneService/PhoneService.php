<?php


namespace App\Services\ModelService\PhoneService;

use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class PhoneService implements PhoneServiceInterface
{

    protected $phone_repository;
    protected $user_repository;
    protected $phone_country_code_repository;

    public function __construct(PhoneRepositoryInterface $phone_repository,
                                UserRepositoryInterface $user_repository,
                                PhoneCountryCodeRepositoryInterface $phone_country_code_repository)
    {
        $this->phone_repository = $phone_repository;
        $this->user_repository = $user_repository;
        $this->phone_country_code_repository = $phone_country_code_repository;
    }

    public function update($id, $data)
    {
        return $this->phone_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->phone_repository->getById($id)->destroy();
    }

    public function create($credentials)
    {
        return  $this->phone_repository->phone->create([
            'phone_number'=>$credentials['phone_number'],
            'is_active'=>$this->user_repository->phones($credentials['user_id'])->count()==0,
            'phone_country_code_id'=>$credentials['phone_country_code_id'],
            'user_id'=>$credentials['user_id']
        ]);
    }

    public function makeActive($id)
    {
        $user = auth()->user();
        $active_phone = $this->user_repository->activePhone($user->id);
        if(!is_null($active_phone)){
            $active_phone->is_active = 0;
            $this->phone_repository->getById($id)->is_active = 1;
            $user->push();
            return true;
        }
        return false;

    }
}
