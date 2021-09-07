<?php


namespace App\Repositories;


use App\Models\ApplicantStatus;
use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;

class ApplicantStatusRepository implements ApplicantStatusRepositoryInterface
{

    public $model;

    public function __construct(ApplicantStatus $applicant_status)
    {
        $this->model = $applicant_status;
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
    public function applicants($id){
        return $this->getById($id)->query()->applicants;
    }
}
