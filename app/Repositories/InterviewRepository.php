<?php


namespace App\Repositories;


use App\Models\Interview;
use App\Repositories\Interfaces\InterviewRepositoryInterface;

class InterviewRepository implements InterviewRepositoryInterface
{
    public $interview;

    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    public function all($n)
    {
        return $this->interview->query()->paginate($n);
    }

    public function getById($id)
    {
        return $this->interview->query()->findOrFail($id);
    }

    public function applicants($id){
        return $this->getById($id)->applicants;
    }

    public function getByStatuses($statuses){
        return $this->interview->query()->whereIn('status_id', $statuses)->get();
    }

    // TODO реализовать возможность получить интервью по смежной таблице пивот
    public function getByApplicant($applicant){
//        return $this->interview->query()->
    }
}
