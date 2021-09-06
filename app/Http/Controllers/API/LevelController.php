<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\Level;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Services\ModelService\LevelService\LevelServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LevelController extends Controller
{
    protected $level_repository;
    protected $level_service;

    public function __construct(LevelRepositoryInterface $level_repository,
                                LevelServiceInterface $level_service)
    {
        $this->level_repository = $level_repository;
        $this->level_service = $level_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->level_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateLevelRequest $request)
    {
        return $this->level_service->create($request->only(['name', 'description']));

    }

    /**
     * @param Level $level
     * @return Response
     */
    public function show($id)
    {
        return $this->level_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param Level $level
     * @return Response
     */
    public function update(UpdateLevelRequest $request, $id)
    {
        return $this->level_service->update($request->only(['name', 'description']), $id);
    }

    /**
     * @param Level $level
     * @return Response
     */
    public function destroy($id)
    {
        return $this->level_service->destroy($id);
    }
}
