<?php


namespace App\Repositories;


use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    /**
     * @param $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }


    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }


    /**
     * @param Company $company_id
     * @param $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function workers($company_id, $n){
        return $this->getById($company_id)->query()->workers->paginate($n);
    }


    /**
     * @param Company $company_id
     * @param $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function projects($company_id, $n){
        return $this->getById($company_id)->query()->projects->paginate($n);
    }
}
