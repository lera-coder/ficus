<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Services\ModelService\WorkerService\WorkerServiceInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->worker_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkerRequest $request)
    {
        return $this->worker_service->create($request->only(["name", "company_id", "position_id", "status_id"]));
    }

    /**
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->worker_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkerRequest $request, $id)
    {
        return $this->worker_service->update($id, $request->only(["name", "company_id", "position_id", "status_id"]));
    }

    /**
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->worker_service->destroy($id);
    }
}
