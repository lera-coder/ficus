<?php


namespace App\Repositories;


use App\Models\Applicant;
use App\Models\Knowledge;
use App\Models\WorkerStatus;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;

class ApplicantRepository implements ApplicantRepositoryInterface
{
    public $model;

    /**
     * ApplicantRepository constructor.
     * @param Applicant $applicant
     */
    public function __construct(Applicant $applicant)
    {
        $this->model = $applicant;
    }

    /**
     * @param $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function status($id){
        return $this->getById($id)->query()->status;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function knowledges($id){
        return $this->getById($id)->query()->knowledges;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function interviews($id){
        return $this->getById($id)->query()->interviews;
    }

    /**
     * @return array
     */
    public function getIdsOfApplicantsWithValidStatus(){
        return $this->model->all()->whereNotIn('status_id', [5,6])->pluck('id')->toArray();
    }
}
