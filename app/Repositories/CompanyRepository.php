<?php


namespace App\Repositories;


use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function all($n)
    {
        return $this->company->paginate($n);
    }

    public function getById($id)
    {
        return $this->company->findOrFail($id);
    }

    public function workers($company_id, $n){
        return $this->getById($company_id)->workers->paginate($n);
    }

    public function projects($company_id, $n){
        return $this->getById($company_id)->projects->paginate($n);
    }
}
