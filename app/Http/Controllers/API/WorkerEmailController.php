<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerEmailRequest;
use App\Http\Requests\UpdateWorkerEmailRequest;
use App\Models\WorkerEmail;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;
use App\Services\ModelService\WorkerEmailService\WorkerEmailServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerEmailController extends Controller
{
    protected $worker_email_repository;
    protected $worker_email_service;

    public function __construct(WorkerEmailRepositoryInterface $worker_email_repository,
                                WorkerEmailServiceInterface $worker_email_service)
    {
        $this->worker_email_repository = $worker_email_repository;
        $this->worker_email_service = $worker_email_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->worker_email_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateWorkerEmailRequest $request)
    {
        return $this->worker_email_service->create($request->only(['email', 'worker_id']));
    }

    /**
     * @param WorkerEmail $workerEmail
     * @return Response
     */
    public function show($id)
    {
        return $this->worker_email_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param WorkerEmail $workerEmail
     * @return Response
     */
    public function update(UpdateWorkerEmailRequest $request, $id)
    {
        return $this->worker_email_service->update($id, $request->only('email'));
    }

    /**
     * @param WorkerEmail $workerEmail
     * @return Response
     */
    public function destroy($id)
    {
        return $this->worker_email_service->destroy($id);
    }
}
