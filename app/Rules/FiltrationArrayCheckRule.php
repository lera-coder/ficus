<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FiltrationArrayCheckRule implements Rule
{
    protected $repository_array;
    protected $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($repository_array)
    {
        $this->repository_array = $repository_array;
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
        $this->field = $attribute;
        $filtration_array = array_unique(explode('_', $value));

        foreach ($filtration_array as $element){
            if(!in_array($element, $this->repository_array)){
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
        return 'Field '.$this->field.' is not valid!';
    }
}
