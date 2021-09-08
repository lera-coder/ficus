<?php

namespace App\Rules;

use App\Services\ModelService\InterviewService\InterviewServiceInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class CheckStatusesForInterviewFiltrationRule implements Rule
{
    protected $interview_service;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->interview_service = App::make(InterviewServiceInterface::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $statuses = $this->interview_service->getValidStatusesArray($value);
        return !in_array(null, $statuses);
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
