<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\WorkerStatusRequest;
use App\Models\WorkerStatus;
use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;
use App\Services\ModelService\WorkerStatusService\WorkerStatusServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerStatusController extends Controller
{
    protected $worker_status_repository;
    protected $worker_status_service;

    public function __construct(WorkerStatusRepositoryInterface $worker_status_repository,
                                WorkerStatusServiceInterface $worker_status_service)
    {
        $this->worker_status_repository = $worker_status_repository;
        $this->worker_status_service = $worker_status_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->worker_status_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(WorkerStatusRequest $request)
    {
        return $this->worker_status_service->create($request->only(['name']));
    }

    /**
     * @param WorkerStatus $workerStatus
     * @return Response
     */
    public function show($id)
    {
        return $this->worker_status_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param WorkerStatus $workerStatus
     * @return Response
     */
    public function update(WorkerStatusRequest $request, $id)
    {
        return $this->worker_status_service->update($id, $request->only(['name']));
    }

    /**
     * @param WorkerStatus $workerStatus
     * @return Response
     */
    public function destroy($id)
    {
        return $this->worker_status_service->destroy($id);
    }
}
