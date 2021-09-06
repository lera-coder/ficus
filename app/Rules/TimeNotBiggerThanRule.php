<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeNotBiggerThanRule implements Rule
{

    protected $givenField;

    protected $timeToCheckForBigger;
    protected $nameOfTimeField;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($timeToCheckForBigger, $nameOfTimeField)
    {
        $this->timeToCheckForBigger = $timeToCheckForBigger;
        $this->nameOfTimeField = $nameOfTimeField;
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
        $this->field = ucfirst(str_replace('_', ' ', $attribute));
        return $value < $this->timeToCheckForBigger;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Attribute '.$this->givenField.' cannot be bigger, than attribute '.$this->nameOfTimeField;
    }
}
