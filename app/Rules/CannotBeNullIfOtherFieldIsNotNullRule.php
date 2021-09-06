<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CannotBeNullIfOtherFieldIsNotNullRule implements Rule
{

    protected $given_field;

    protected $second_value;
    protected $second_field;


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($second_value, $second_field)
    {
        $this->second_value = $second_value;
        $this->second_field = $second_field;
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
        return gettype($attribute) == gettype($this->second_value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Error! Fields '.$this->second_field.' and '.$this->given_field.' should be both filled or not filled!';
    }
}
