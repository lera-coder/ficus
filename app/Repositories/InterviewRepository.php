<?php


namespace App\Repositories;

use App\Models\Interview;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use App\Traits\Filterable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
        return $this->getById($id)->interviewer;
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
     * @param array $request_filtration_array
     * @return LengthAwarePaginator
     */
    public function filtration(array $request_filtration_array)
    {
        $result_query = DB::table('interviews as i')
            ->join('applicants_interviews as ai', 'i.id', '=', 'ai.interview_id')
            ->join('applicants as a',  'ai.applicant_id', '=', 'a.id')
            ->join('users as u', 'i.interviewer_id', '=', 'u.id')
            ->select('a.name as applicant_name', 'a.id as applicant_id', 'u.name as user_name', 'i.*' );

        $result_query = $this->filtationByStatuses($request_filtration_array, $result_query);
        $result_query = $this->filtrationByInterviewers($request_filtration_array, $result_query);
        $result_query = $this->filtrationByApplicants($request_filtration_array, $result_query);
        $result_query = $this->filtrationByDate($request_filtration_array, $result_query);
        $result_query = $this->sort($request_filtration_array, $result_query);
        $result_query = $this->paginate($request_filtration_array, $result_query);
        return $result_query;
    }

    /**
     * @param $request_filtration_array
     * @param $result_query
     * @return Builder
     */
    public function filtationByStatuses(array $request_filtration_array, Builder $result_query): Builder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'statuses', 'status_id');
    }

    /**
     * @param array $request_filtration_array
     * @param Builder $result_query
     * @return Builder
     */
    public function filtrationByInterviewers(array $request_filtration_array, Builder $result_query): Builder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'interviewers', 'interviewer_id');
    }

    /**
     * @param array $request_filtration_array
     * @param Builder $result_query
     * @return Builder
     */
    public function filtrationByApplicants(array $request_filtration_array, Builder $result_query): Builder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'applicants', 'applicant_id');
    }

    /**
     * @param array $request_filtration_array
     * @param Builder $result_query
     * @return Builder
     */
    public function filtrationByDate(array $request_filtration_array, Builder $result_query): Builder
    {
        if (isset($request_filtration_array['interview-dates'])) {
            $result_query = $this->filtrationByDates($result_query,
                $request_filtration_array['interview-dates'],
                'dates_between',
                'interview_time', 'dates_in');
        }

        return $result_query;
    }


}
