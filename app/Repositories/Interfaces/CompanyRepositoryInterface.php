<?php


namespace App\Repositories\Interfaces;


use App\Models\Company;

interface CompanyRepositoryInterface extends RepositoryInterface
{

    public function workers(int $company_id, int $n);

    public function projects(int $company_id, int $n);

}
