<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Services\ModelService\LevelService\LevelServiceInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->level_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLevelRequest $request)
    {
        return $this->level_service->create($request->only(['name', 'description']));

    }

    /**
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->level_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLevelRequest $request, $id)
    {
        return $this->level_service->update($request->only(['name', 'description']), $id);
    }

    /**
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->level_service->destroy($id);
    }
}
