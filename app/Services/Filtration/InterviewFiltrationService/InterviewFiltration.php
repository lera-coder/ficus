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
    public function apply($filtration_values_keys_array, $fields){
        $this->fields = $fields;
        $filtration_values_keys_array = $this->getArray($filtration_values_keys_array, $fields);
        $filtration_values_keys_array = $this->convertStatusesToIds($filtration_values_keys_array);
        $filtration_values_keys_array = $this->convertInterviewDate($filtration_values_keys_array);
        return $this->interview_repository->filtration($filtration_values_keys_array);
    }


    /**
     * The statuses are given in format "in-progress"
     * The statuses are converted to format "in progress"
     * And then the primary keys are taken from database via repository
     *
     * @param $array
     * @return mixed
     */
    protected function convertStatusesToIds($filtration_values_keys_array){
        if(key_exists('status', $filtration_values_keys_array)) {
            $statuses_id_array = [];

            foreach ($filtration_values_keys_array['status'] as $status) {
                $status_id = $this->interview_status_repository
                    ->getIdByName(str_replace('-', ' ', $status));

                if(!is_null($status_id)){
                    array_push($statuses_id_array, $status_id);
                }
            }
            if(count($statuses_id_array) > 0) {
                $filtration_values_keys_array['status'] = $statuses_id_array;
            }
            else{
                unset($filtration_values_keys_array['status']);
            }
        }

        return $filtration_values_keys_array;

    }

    /**
     * Check for rightly written dates. User can enter the areas of date with separator |
     * And Can enter some dates with separator _,
     * All dates must be in format Y:M:D (2021:06:22)
     * First date in areas should be earlier, than second
     *
     * @param $array
     */
    protected function convertInterviewDate($filtration_values_keys_array){
        if(key_exists('interview-date', $filtration_values_keys_array)){
            $array_date_between = [];
            $array_date_in = [];

            foreach ($filtration_values_keys_array['interview-date'] as $interview_date) {
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

            unset($filtration_values_keys_array['interview-date']);
            if(count($array_date_between)>0){
                $filtration_values_keys_array['interview-date-between'] = $array_date_between;
            }
            if(count($array_date_in)>0) {
                $filtration_values_keys_array['interview-date-in'] = $array_date_in;
            }
        }
        return $filtration_values_keys_array;
    }








}
