<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckForAbilityToPublishInterviewRule implements Rule
{

    protected $link;
    protected $interview_time;
    protected $sending_time;
    protected $interviewer_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($link, $interview_time, $sending_time, $interviewer_id)
    {
        $this->link = $link;
        $this->interview_time = $interview_time;
        $this->sending_time = $sending_time;
        $this->interviewer_id = $interviewer_id;
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
        return ($value != 2)&&(is_null($this->link))
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'To publish this interview should be filled fields link, time'.
            ' of interview, time of sending and interviewer';
    }
}
