<?php


namespace App\Services\Filtration\InterviewFiltrationService;


use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use App\Services\Filtration\Filterable;

class InterviewFiltration implements InterviewFiltrationInterface
{
    use Filterable;

    protected $route;
    protected $interview_repository;
    protected $interview_status_repository;
    protected $fields = ['status', 'applicant', 'interviewer', 'interview-date'];

    public function __construct(InterviewRepositoryInterface $interview_repository,
                                InterviewStatusRepositoryInterface $interview_status_repository)
    {
        $this->interview_repository = $interview_repository;
        $this->interview_status_repository = $interview_status_repository;
    }


    /**
     * @param $route
     * @return mixed
     */
    public function apply($route){
        $this->route = $route;
        $array = $this->getArray($this->route, $this->fields);
        $array = $this->convertStatusesToIds($array);
        $array = $this->convertInterviewDate($array);

        return $this->interview_repository->filtration($array);

    }


    /**
     * The statuses are given in format "in-progress"
     * The statuses are converted to format "in progress"
     * And then the primary keys are taken from database via repository
     *
     * @param $array
     * @return mixed
     */
    protected function convertStatusesToIds($array){
        if(key_exists('status', $array)) {
            $statuses_id_array = [];

            foreach ($array['status'] as $status) {
                $status_id = $this->interview_status_repository
                    ->getIdByName(str_replace('-', ' ', $status));

                if(!is_null($status_id)){
                    array_push($statuses_id_array, $status_id);
                }
            }
            if(count($statuses_id_array) > 0) {
                $array['status'] = $statuses_id_array;
            }
            else{
                unset($array['status']);
            }
        }

        return $array;

    }

    /**
     * Check for rightly written dates. User can enter the areas of date with separator |
     * And Can enter some dates with separator _,
     * All dates must be in format Y:M:D (2021:06:22)
     * First date in areas should be earlier, than second
     *
     * @param $array
     */
    protected function convertInterviewDate($array){
        if(key_exists('interview-date', $array)){
            $array_date_between = [];
            $array_date_in = [];

            foreach ($array['interview-date'] as $interview_date) {
                if (str_contains($interview_date, '|')){
                    $array_date_between_current = explode('|', $interview_date);
                    $array_date_between_current = [$array_date_between_current[0],
                        $array_date_between_current[count($array_date_between_current) - 1]];

                    if($this->validateDate($array_date_between_current[0]) &&
                        $this->validateDate($array_date_between_current[1]) &&
                        $this->checkDateIsEarlier($array_date_between_current[0], $array_date_between_current[1])){
                            array_push($array_date_between, $array_date_between_current);
                        }
                }

                else{
                    if($this->validateDate($interview_date)){
                        array_push($array_date_in, $interview_date);
                    }
                }
            }

            unset($array['interview-date']);
            if(count($array_date_between)>0){
                $array['interview-date-between'] = $array_date_between;
            }
            if(count($array_date_in)>0) {
                $array['interview-date-in'] = $array_date_in;
            }
        }
        return $array;
    }








}
