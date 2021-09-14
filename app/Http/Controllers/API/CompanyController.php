<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CompanyRequests\CreateCompanyRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Services\ModelService\CompanyService\CompanyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    protected $company_repository;
    protected $company_service;

    public function __construct(CompanyRepositoryInterface $company_repository,
                                CompanyServiceInterface $company_service)
    {
        $this->company_repository = $company_repository;
        $this->company_service = $company_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->company_repository->all(20);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(CreateCompanyRequest $request)
    {
        return $this->company_service->create($request->validated());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->company_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return $this->company_service->update($id, $request->validated());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->company_service->destroy($id);
    }
}
