<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Technology;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;
use App\Services\ModelService\TechnologyService\TechnologyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TechnologyController extends Controller
{
    protected $technology_repository;
    protected $technology_service;

    public function __construct(TechnologyRepositoryInterface $technology_repository,
                                TechnologyServiceInterface $technology_service)
    {
        $this->technology_repository = $technology_repository;
        $this->technology_service = $technology_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->technology_repository->all(50);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateTechnologyRequest $request)
    {
        return $this->technology_service->create($request->only(['name', 'description']));
    }

    /**
     * @param Technology $technology
     * @return Response
     */
    public function show($id)
    {
        return $this->technology_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param Technology $technology
     * @return Response
     */
    public function update(UpdateTechnologyRequest $request, $id)
    {
        return $this->technology_service->update($id, $request->only(['name', 'description']));
    }

    /**
     * @param Technology $technology
     * @return Response
     */
    public function destroy($id)
    {
        $this->technology_service->destroy($id);
    }
}
