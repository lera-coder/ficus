<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\ResourcesForPhoneBook\PhoneBookApplicantCollection;
use App\Http\Resources\ResourcesForPhoneBook\PhoneBookUserCollection;
use App\Http\Resources\ResourcesForPhoneBook\PhoneBookWorkerCollection;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WorkerRepositoryInterface;

class PhoneBookController extends Controller
{
    protected $user_repository;
    protected $applicant_repository;
    protected $worker_repository;

    public function __construct(UserRepositoryInterface $user_repository,
                                ApplicantRepositoryInterface $applicant_repository,
                                WorkerRepositoryInterface $worker_repository)
    {
        $this->user_repository = $user_repository;
        $this->applicant_repository = $applicant_repository;
        $this->worker_repository = $worker_repository;
    }

    public function users()
    {
        return new PhoneBookUserCollection($this->user_repository->all(20));
    }

    public function applicants()
    {
        return new PhoneBookApplicantCollection($this->applicant_repository->all(20));
    }

    public function workers()
    {
        return new PhoneBookWorkerCollection($this->worker_repository->all(20));
    }
}
