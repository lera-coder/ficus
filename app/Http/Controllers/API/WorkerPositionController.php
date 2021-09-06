<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\WorkerPositionRequest;
use App\Models\WorkerPosition;
use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;
use App\Services\ModelService\WorkerPositionService\WorkerPositionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerPositionController extends Controller
{

    protected $worker_position_repository;
    protected $worker_position_service;

    public function __construct(WorkerPositionRepositoryInterface $worker_position_repository,
                                WorkerPositionServiceInterface $worker_position_service)
    {
        $this->worker_position_repository = $worker_position_repository;
        $this->worker_position_service = $worker_position_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->worker_position_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(WorkerPositionRequest $request)
    {
        return $this->worker_position_service->create($request->only(['name']));
    }

    /**
     * @param WorkerPosition $workerPosition
     * @return Response
     */
    public function show($id)
    {
        return $this->worker_position_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param WorkerPosition $workerPosition
     * @return Response
     */
    public function update(WorkerPositionRequest $request, $id)
    {
        return $this->worker_position_service->update($id, $request->only(['name']));
    }

    /**
     * @param WorkerPosition $workerPosition
     * @return Response
     */
    public function destroy($id)
    {
        return $this->worker_position_service->destroy($id);
    }
}
