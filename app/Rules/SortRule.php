<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SortRule implements Rule
{
    protected $sort_array;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($sort_array)
    {
        $this->sort_array = $sort_array;
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
        if(str_contains('_', $value)){
            $sort_value = explode('_', $value);
            if(!in_array($sort_value[1], ['asc', 'desc'])) return false;
            return in_array($sort_value[0], $this->sort_array);
        }
        else{
            return in_array($value, $this->sort_array);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The items cannot be sorted this way! ';
    }
}
