<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayNotEmptyRule implements Rule
{
    protected $attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $this->attribute = $attribute;
        return count($value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Field '.$this->attribute.' cannot be empty array!';
    }
}
