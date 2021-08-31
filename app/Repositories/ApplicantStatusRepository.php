<?php


namespace App\Repositories;


use App\Models\ApplicantStatus;
use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;

class ApplicantStatusRepository implements ApplicantStatusRepositoryInterface
{

    public $applicant_status;

    public function __construct(ApplicantStatus $applicant_status)
    {
        $this->applicant_status = $applicant_status;
    }

    public function all($n)
    {
        return $this->applicant_status->paginate($n);
    }

    public function getById($id)
    {
        return $this->applicant_status->findOrFail($id);
    }

    public function applicants($id){
        return $this->getById($id)->applicants;
    }
}
