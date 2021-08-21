<?php


namespace App\Services\ModelService\PhoneService;


use App\Models\Phone;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class PhoneService implements PhoneServiceInterface
{

    protected $repository;
    protected $user_repository;

    public function __construct(PhoneRepositoryInterface $repository, UserRepositoryInterface $user_repository)
    {
        $this->repository = $repository;
        $this->user_repository = $user_repository;
    }

    public function update($id, $data)
    {
        $phone = $this->repository->getById($id);
        $phone->phone_number=$data['phone_number'];

        //update from phonecode repository
    }

    public function destroy($id)
    {
        $this->repository->getById($id)->destroy();
    }

    public function create($credentials, $user_id)
    {
        return  Phone::create([
            'phone_number'=>$credentials['phone_number'],
            'is_active'=>$this->user_repository->phones()->count()==0,
            'phone_country_code_id'=>PhoneCountryCode::where('code',$country_code)->first()->id,
            'user_id'=>$this->id
        ]);
    }

    public function makeActive($id)
    {
        // TODO: Implement makeActive() method.
    }
}
