<?php

namespace App\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    public Company $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n):LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }


    /**
     * @param int $id
     * @return Company
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Company
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $company_id
     * @param int $n
     * @return LengthAwarePaginator
     * @throws ModelNotFoundException
     */
    public function workers(int $company_id, int $n):LengthAwarePaginator
    {
        return $this->getById($company_id)->query()->workers->paginate($n);
    }


    /**
     * @param int $company_id
     * @param int $n
     * @return LengthAwarePaginator
     * @throws ModelNotFoundException
     */
    public function projects(int $company_id, int $n):LengthAwarePaginator
    {
        return $this->getById($company_id)->query()->projects->paginate($n);
    }
}
