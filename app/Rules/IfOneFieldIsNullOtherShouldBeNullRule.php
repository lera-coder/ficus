<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IfOneFieldIsNullOtherShouldBeNullRule implements Rule
{
    protected $dependent_field;

    protected $main_value;
    protected $main_field;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($main_value, $main_field)
    {
        $this->main_field = $main_field;
        $this->main_value = $main_value;
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
        $this->dependent_field = $attribute;
        return !(is_null($this->main_value) && !is_null($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Attribute '.$this->dependent_field.' cannot be filled, if '. $this->main_field.' is not filled!';
    }
}
