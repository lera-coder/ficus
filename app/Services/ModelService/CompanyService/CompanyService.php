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

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->company_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id):bool
    {
        return $this->company_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->company_repository->model->create($data);
    }
}
