<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerPhoneRequest;
use App\Http\Requests\UpdateWorkerPhoneRequest;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;
use App\Services\ModelService\WorkerPhoneService\WorkerPhoneServiceInterface;

class WorkerPhoneController extends Controller
{
    protected $worker_phone_repository;
    protected $worker_phone_service;

    public function __construct(WorkerPhoneRepositoryInterface $worker_phone_repository,
                                WorkerPhoneServiceInterface  $worker_phone_service)
    {
        $this->worker_phone_repository = $worker_phone_repository;
        $this->worker_phone_service = $worker_phone_service;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->worker_phone_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkerPhoneRequest $request)
    {
        return $this->worker_phone_service->create($request->only("phone_number", "operator", "worker_id"));
    }

    /**
     * @param  \App\Models\WorkerPhone  $workerPhone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->worker_phone_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkerPhone  $workerPhone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkerPhoneRequest $request, $id)
    {
        return $this->worker_phone_service->update($id, $request->only(["phone_number", "operator"]));
    }

    /**
     * @param  \App\Models\WorkerPhone  $workerPhone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->worker_phone_service->destroy($id);
    }
}
