<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\RoleRequest;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\ModelService\RoleService\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role_repository;
    protected $role_service;

    public function __construct(RoleRepositoryInterface $role_repository,
                                RoleServiceInterface $role_service)
    {
        $this->role_repository = $role_repository;
        $this->role_service = $role_service;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->role_repository->all(50);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        return $this->role_service->create($request->only['name']);
    }

    /**
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->role_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        return $this->role_service->update($id, $request->only['name']);
    }

    /**
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->role_service->destroy($id);
    }
}
