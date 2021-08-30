<?php


namespace App\Repositories\Interfaces;


use App\Models\Company;

interface CompanyRepositoryInterface extends RepositoryInterface
{

    public function workers(Company $company, $n);

    public function projects(Company $company, $n);

}
