<?php


namespace App\Repositories;

use App\Models\Interview;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InterviewRepository implements InterviewRepositoryInterface
{
    public $interview;
    protected $applicant_repository;

    public function __construct(Interview $interview,
                                ApplicantRepositoryInterface $applicant_repository)
    {
        $this->interview = $interview;
        $this->applicant_repository = $applicant_repository;
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

    public function getByApplicant($applicant_id){
        return $this->applicant_repository->interviews($applicant_id);
    }

    public function getByInterviewer($interviewer_id){
        return $this->interview->query()->where('interviewer_id', $interviewer_id);
    }

    public function filtration($request_array){
        $result = $this->interview->all();

        if(key_exists('interview-date-between', $request_array)){
            $date_result = $result->whereBetween('interview_time', $request_array['interview-date-between'][0]);

            foreach (array_slice($request_array['interview-date-between'], 1) as $date){
                $date_result = $result->union($result->whereBetween('interview_time', $date));
            }

            $result = $date_result;
        }

        if(key_exists('interview-date-in', $request_array)){
                $date_result = $result->union($result->whereIn('interview_time', $request_array['interview-date-in']));

            $result = $date_result;
        }


        if(key_exists('interviewer', $request_array)){
           $result = $result->whereIn('interviewer_id', $request_array['interviewer']);
        }

        if(key_exists('status', $request_array)){
            $result = $result->whereIn('status_id', $request_array['status']);
        }

        if(key_exists('applicant', $request_array)){
            $interview_ids = DB::table('applicants_interviews')
                ->whereIn('applicant_id', $request_array['applicant'])->get()->pluck('id')->toArray();
            $result = $result->whereIn('id', $interview_ids);
        }


        return $result;



    }
}
