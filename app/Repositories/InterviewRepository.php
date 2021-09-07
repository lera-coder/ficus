<?php


namespace App\Repositories;

use App\Models\Interview;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use App\Traits\Filterable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HigherOrderCollectionProxy;

class InterviewRepository implements InterviewRepositoryInterface
{
    use Filterable;

    public $model;
    protected $applicant_repository;
    protected $interview_status_repository;

    public function __construct(Interview $interview,
                                ApplicantRepositoryInterface $applicant_repository,
                                InterviewStatusRepositoryInterface $interview_status_repository)
    {
        $this->model = $interview;
        $this->applicant_repository = $applicant_repository;
        $this->interview_status_repository = $interview_status_repository;
    }


    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $statuses
     * @return Builder[]|Collection
     */
    public function getByStatuses($statuses)
    {
        return $this->model->query()->whereIn('status_id', $statuses)->get();
    }

    /**
     * @param $applicant_id
     * @return mixed
     */
    public function getByApplicant($applicant_id)
    {
        return $this->applicant_repository->interviews($applicant_id);
    }

    /**
     * @param $interviewer_id
     * @return Builder
     */
    public function getByInterviewer($interviewer_id)
    {
        return $this->model->query()->where('interviewer_id', $interviewer_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function status($id)
    {
        return $this->getById($id)->status;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function interviewer($id)
    {
        return $this->getById($id)->interviwer;
    }


    /**
     * @param $id
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function applicants($id)
    {
        return $this->getById($id)->applicants;
    }


    /**
     * @param $request_array
     * @return Interview[]|Collection
     */
    public function filtration($request_data)
    {
        return $this->detectFiltrationTypesCallFiltrations($request_data);
    }

    /**
     * @param $request_data
     * @return mixed
     */
    public function detectFiltrationTypesCallFiltrations($request_data)
    {
//        if(fi)
        $result = $this->model->all();

        //Filtration by time diaposones
        $result = $this->filtrationByInterviewTimeDiapason($result, $request_data);
        //Filtration by one day
        $result = $this->filtrationByTimeIn($result, $request_data);
        //Filtration by interviewer
        $result = $this->filtrationWhereInByKeys
        ($result, $request_data, 'interviewer', 'interviewer_id');
        //Filtration by Status
        $result = $this->filtrationByStatus($result, $request_data);

        $result = $this->filtrationByApplicant($result, $request_data);

        return $result;
    }

    /**
     * @param $result_data
     * @param $request_data
     * @return mixed
     */
    protected function filtrationByInterviewTimeDiapason($result_data, $request_data){
        return $this->filtrationByTimeBetween
        ($result_data, $request_data, 'interview-date', 'interview-date');
    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByTimeIn($result, $request_array)
    {
        if (key_exists('interview-date', $request_array)) {
            $array_time_in = $this->getArrayTimeIn($request_array['interview-date']);

            foreach ($array_time_in as $date) {
                $date_result = DB::table('interviews')
                    ->whereDate('interview_time', $date)->get();
                $result = $result->union($date_result);
            }
        }
        return $result;
    }


    /**
     * @param $request_array
     * @return array
     */
    protected function getArrayTimeIn($request_array)
    {
        return array_filter($request_array, function ($value) {
            return !str_contains($value, '|');
        });
    }

    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByStatus($result_data, $request_data)
    {
        if (array_key_exists('status', $request_data)) {
            return $this->filtrationWithConvertedData(
                $result_data,
                $this->interview_status_repository->getIdsForFiltration($request_data['status']),
                'status_id');
        }
        return $result_data;
    }

    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByApplicant($result_data, $request_data)
    {

        if (array_key_exists('applicant', $request_data)) {
            return $this->filtrationWithConvertedData(
                $result_data, DB::table('applicants_interviews')
                ->whereIn('applicant_id', $request_data['applicant'])->get()->pluck('id')->toArray(),
                'id');
        }
        return $result_data;


    }

    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByInterviewer($result, $request_data)
    {
        return $this->filtrationWhereInByKeys
        ($result, $request_data, 'interviewer', 'interviewer_id');
    }


}
