<?php


namespace App\Services\ModelService\PhoneCountryCodeService;


use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;

class PhoneCountryCodeService implements PhoneCountryCodeServiceInterface
{
    protected $phone_country_code_repository;

    public function __construct(PhoneCountryCodeRepositoryInterface $phone_country_code_repository)
    {
        $this->phone_country_code_repository = $phone_country_code_repository;
    }

    public function update($id, $data)
    {
        return $this->phone_country_code_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->phone_country_code_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->phone_country_code_repository->phone_country_code->create($data);
    }
}
