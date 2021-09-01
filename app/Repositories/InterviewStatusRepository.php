<?php


namespace App\Repositories;


use App\Models\InterviewStatus;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;

class InterviewStatusRepository implements InterviewStatusRepositoryInterface
{

    public $interviewStatus;

    public function __construct(InterviewStatus $interviewStatus){
        $this->interviewStatus = $interviewStatus;
    }

    public function all($n){
        return $this->interviewStatus->query()->paginate($n);
    }

    public function getById($id){
        return $this->interviewStatus->query()->findOrFail($id);
    }

    public function getIdByName($status_name){
        $model = $this->interviewStatus->query()->where('name', $status_name)->first();
        return $model ? $model->id : null;
    }
}