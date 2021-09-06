<?php

namespace App\Rules;

use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class CheckStatusesForInterviewFiltrationRule implements Rule
{

    protected $interview_statuses_repository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->interview_statuses_repository = App::make(InterviewStatusRepositoryInterface::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $statuses_id = $this->interview_statuses_repository->getAllIds();
        $statuses_get_by_filtration = $this->interview_statuses_repository
            ->getIdsForFiltration($value);

        foreach ($statuses_get_by_filtration as $status){
            if(!in_array($status, $statuses_id)){
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The status value is not valid!';
    }
}
