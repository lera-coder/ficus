<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Models\Worker;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Services\ModelService\WorkerService\WorkerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerController extends Controller
{
    protected $worker_repository;
    protected $worker_service;

    public function __construct(WorkerRepositoryInterface $worker_repository,
                                WorkerServiceInterface $worker_service)
    {
        $this->worker_repository = $worker_repository;
        $this->worker_service = $worker_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->worker_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateWorkerRequest $request)
    {
        return $this->worker_service->create($request->only(["name", "company_id", "position_id", "status_id"]));
    }

    /**
     * @param Worker $worker
     * @return Response
     */
    public function show($id)
    {
        return $this->worker_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param Worker $worker
     * @return Response
     */
    public function update(UpdateWorkerRequest $request, $id)
    {
        return $this->worker_service->update($id, $request->only(["name", "company_id", "position_id", "status_id"]));
    }

    /**
     * @param Worker $worker
     * @return Response
     */
    public function destroy($id)
    {
        return $this->worker_service->destroy($id);
    }
}
