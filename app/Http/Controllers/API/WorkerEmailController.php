<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateWorkerEmailRequest;
use App\Http\Requests\UpdateWorkerEmailRequest;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;
use App\Services\ModelService\WorkerEmailService\WorkerEmailServiceInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->worker_email_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkerEmailRequest $request)
    {
        return $this->worker_email_service->create($request->only(['email', 'worker_id']));
    }

    /**
     * @param  \App\Models\WorkerEmail  $workerEmail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->worker_email_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkerEmail  $workerEmail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkerEmailRequest $request, $id)
    {
        return $this->worker_email_service->update($id, $request->only('email'));
    }

    /**
     * @param  \App\Models\WorkerEmail  $workerEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->worker_email_service->destroy($id);
    }
}
