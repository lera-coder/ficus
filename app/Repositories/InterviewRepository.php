<?php


namespace App\Repositories;

use App\Models\Interview;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use DateInterval;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HigherOrderCollectionProxy;

class InterviewRepository implements InterviewRepositoryInterface
{
    public $interview;
    protected $applicant_repository;
    protected $interview_status_repository;

    public function __construct(Interview $interview,
                                ApplicantRepositoryInterface $applicant_repository,
                                InterviewStatusRepositoryInterface  $interview_status_repository)
    {
        $this->interview = $interview;
        $this->applicant_repository = $applicant_repository;
        $this->interview_status_repository = $interview_status_repository;
    }


    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->interview->query()->paginate($n);
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
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->interview->query()->findOrFail($id);
    }

    /**
     * @param $statuses
     * @return Builder[]|Collection
     */
    public function getByStatuses($statuses)
    {
        return $this->interview->query()->whereIn('status_id', $statuses)->get();
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
        return $this->interview->query()->where('interviewer_id', $interviewer_id);
    }


    /**
     * @param $request_array
     * @return Interview[]|Collection
     */
    public function filtration($request_array)
    {
        $result = $this->interview->all();
        $result = $this->filtrationByTimeBetween($result, $request_array);
        $result = $this->filtrationByTimeIn($result, $request_array);
        $result = $this->filtrationByInterviewer($result, $request_array);
        $result = $this->filtrationByStatus($result, $request_array);
        $result = $this->filtrationByApplicant($result, $request_array);

        return $result;

    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByTimeBetween($result, $request_array)
    {
        if (key_exists('interview-date', $request_array)) {
            $array_time_between = $this->getArrayTimeBetween($request_array['interview-date']);
            $date_result = collect();
            foreach ($array_time_between as $date) {
                $date = explode('|', $date);
                $date = $this->renovateDate($date);
                $date_result = $result->whereBetween('interview_time', $date)->union($date_result);
            }
            return $date_result;
        }
        return $result;
    }

    /**
     * @param $request_array
     * @return array
     */
    protected function getArrayTimeBetween($request_array){
        return array_filter($request_array, function ($value){
            return str_contains( $value, '|');
        });
    }


    /**
     * This function is for adding one day to last day of range
     * It's for making not absolute boundary
     * @param $date
     * @return mixed
     * @throws \Exception
     */
    protected function renovateDate($date){
        $date[1] = new DateTime($date[1]);
        $date[1]->add(new DateInterval('P1D'));
        $date[1] = $date[1]->format('Y-m-d');
        return $date;
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

            foreach ($array_time_in as $date){
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
    protected function getArrayTimeIn($request_array){
        return array_filter($request_array, function ($value){
            return !str_contains( $value, '|');
        });
    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByInterviewer($result, $request_array)
    {
        if (key_exists('interviewer', $request_array)) {
            return $result->whereIn('interviewer_id', array_values($request_array['interviewer']));
        }
        return $result;
    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByStatus($result, $request_array)
    {
        if (key_exists('status', $request_array)) {
            return $result->whereIn('status_id',
                $this->interview_status_repository->getIdsForFiltration($request_array['status']));
        }
        return $result;
    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    protected function filtrationByApplicant($result, $request_array)
    {
        if (key_exists('applicant', $request_array)) {
            $interview_ids = DB::table('applicants_interviews')
                ->whereIn('applicant_id', $request_array['applicant'])->get()->pluck('id')->toArray();
            return $result->whereIn('id', $interview_ids);
        }
        return $result;

    }


}
