<?php


namespace App\Repositories;


use App\Models\Applicant;
use App\Models\Knowledge;
use App\Models\WorkerStatus;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;

class ApplicantRepository implements ApplicantRepositoryInterface
{
    public $applicant;

    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }

    public function all($n)
    {
        return $this->applicant->paginate($n);
    }

    public function getById($id)
    {
        return $this->applicant->findOrFail($id);
    }

    public function status($id){
        return $this->getById($id)->status;
    }

    public function knowledges($id){
        return $this->getById($id)->knowledges;
    }

    public function interviews($id){
        return $this->getById($id)->interviews;
    }
}
