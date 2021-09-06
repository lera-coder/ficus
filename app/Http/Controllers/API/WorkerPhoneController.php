<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerPhoneRequest;
use App\Http\Requests\UpdateWorkerPhoneRequest;
use App\Models\WorkerPhone;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;
use App\Services\ModelService\WorkerPhoneService\WorkerPhoneServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerPhoneController extends Controller
{
    protected $worker_phone_repository;
    protected $worker_phone_service;

    public function __construct(WorkerPhoneRepositoryInterface $worker_phone_repository,
                                WorkerPhoneServiceInterface $worker_phone_service)
    {
        $this->worker_phone_repository = $worker_phone_repository;
        $this->worker_phone_service = $worker_phone_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->worker_phone_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateWorkerPhoneRequest $request)
    {
        return $this->worker_phone_service->create($request->only("phone_number", "operator", "worker_id"));
    }

    /**
     * @param WorkerPhone $workerPhone
     * @return Response
     */
    public function show($id)
    {
        return $this->worker_phone_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param WorkerPhone $workerPhone
     * @return Response
     */
    public function update(UpdateWorkerPhoneRequest $request, $id)
    {
        return $this->worker_phone_service->update($id, $request->only(["phone_number", "operator"]));
    }

    /**
     * @param WorkerPhone $workerPhone
     * @return Response
     */
    public function destroy($id)
    {
        return $this->worker_phone_service->destroy($id);
    }
}
