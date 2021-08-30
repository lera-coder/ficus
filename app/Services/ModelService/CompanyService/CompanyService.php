<?php


namespace App\Services\ModelService\CompanyService;


use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyService implements CompanyServiceInterface
{
    protected $company_repository;

    public function __construct(CompanyRepositoryInterface $company_repository)
    {
        $this->company_repository = $company_repository;
    }

    public function update($id, $data)
    {
        return $this->company_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->company_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->company_repository->company->create($data);
    }
}
