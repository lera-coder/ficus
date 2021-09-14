<?php


namespace App\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Models\Interview;
use App\Models\InterviewStatus;
use App\Models\User;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use App\Traits\Filterable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class InterviewRepository implements InterviewRepositoryInterface
{
    use Filterable;

    public Interview $model;
    protected ApplicantRepositoryInterface $applicant_repository;
    protected InterviewStatusRepositoryInterface $interview_status_repository;

    public function __construct(Interview $interview,
                                ApplicantRepositoryInterface $applicant_repository,
                                InterviewStatusRepositoryInterface $interview_status_repository)
    {
        $this->model = $interview;
        $this->applicant_repository = $applicant_repository;
        $this->interview_status_repository = $interview_status_repository;
    }


    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return InterviewStatus
     * @throws ModelNotFoundException
     */
    public function status($id): InterviewStatus
    {
        return $this->getById($id)->query()->status;
    }

    /**
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Model
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $interviewer_id
     * @return User
     * @throws ModelNotFoundException
     */
    public function interviewer(int $interviewer_id):User
    {
        return $this->getById($interviewer_id)->interviewer;
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function applicants(int $id):Collection
    {
        return $this->getById($id)->applicants;
    }


    /**
     * @param array $statuses
     * @return Collection
     */
    public function getByStatuses(array $statuses): Collection
    {
        return $this->model->query()->whereIn('status_id', $statuses)->get();
    }

    /**
     * @param int $applicant_id
     * @return Interview
     */
    public function getByApplicant(int $applicant_id): Interview
    {
        return $this->applicant_repository->interviews($applicant_id);
    }

    /**
     * @param int $interviewer_id
     * @return EloquentBuilder
     */
    public function getByInterviewer(int $interviewer_id): EloquentBuilder
    {
        return $this->model->query()->where('interviewer_id', $interviewer_id);
    }


    /**
     * @param array $request_filtration_array
     * @return LengthAwarePaginator
     */
    public function filtration(array $request_filtration_array):LengthAwarePaginator
    {
        $result_query = DB::table('interviews as i')
            ->join('applicants_interviews as ai', 'i.id', '=', 'ai.interview_id')
            ->join('applicants as a', 'ai.applicant_id', '=', 'a.id')
            ->join('users as u', 'i.interviewer_id', '=', 'u.id')
            ->select('a.name as applicant_name', 'a.id as applicant_id', 'u.name as user_name', 'i.*');

        $result_query = $this->filtrationByStatuses($request_filtration_array, $result_query);
        $result_query = $this->filtrationByInterviewers($request_filtration_array, $result_query);
        $result_query = $this->filtrationByApplicants($request_filtration_array, $result_query);
        $result_query = $this->filtrationByDate($request_filtration_array, $result_query);
        $result_query = $this->sort($request_filtration_array, $result_query);
        $result_query = $this->paginate($request_filtration_array, $result_query);
        return $result_query;
    }


    /**
     * @param array $request_filtration_array
     * @param QueryBuilder $result_query
     * @return QueryBuilder
     */
    public function filtrationByStatuses(
        array $request_filtration_array, QueryBuilder $result_query): QueryBuilder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'statuses', 'status_id');
    }

    /**
     * @param array $request_filtration_array
     * @param QueryBuilder $result_query
     * @return QueryBuilder
     */
    public function filtrationByInterviewers(
        array $request_filtration_array, QueryBuilder $result_query): QueryBuilder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'interviewers', 'interviewer_id');
    }

    /**
     * @param array $request_filtration_array
     * @param QueryBuilder $result_query
     * @return QueryBuilder
     */
    public function filtrationByApplicants(array $request_filtration_array,
                                           QueryBuilder $result_query): QueryBuilder
    {
        return $this->filtrationWhereInByKeys
        ($result_query, $request_filtration_array, 'applicants', 'applicant_id');
    }

    /**
     * @param array $request_filtration_array
     * @param QueryBuilder $result_query
     * @return QueryBuilder
     */
    public function filtrationByDate(array $request_filtration_array,
                                     QueryBuilder $result_query): QueryBuilder
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
