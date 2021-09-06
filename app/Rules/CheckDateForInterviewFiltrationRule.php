<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CheckDateForInterviewFiltrationRule implements Rule
{
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $date) {
            if (str_contains($date, '|')) {
                $sub_array_date_between = explode('|', $date);
                if (count($sub_array_date_between) != 2) {
                    return false;
                }
                if (!$this->validateDate($sub_array_date_between[0])) {
                    return false;
                }
                if (!$this->validateDate($sub_array_date_between[1])) {
                    return false;
                }
                if($sub_array_date_between[0] > $sub_array_date_between[1]){
                    return false;
                }

            } else {
                if (!$this->validateDate($date)) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * @param $date
     * @return bool
     */
    protected function validateDate($date)
    {
        $validator =  Validator::make(['date' => $date], ['date' => 'date_format:Y-m-d']);
        return !$validator->fails();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid date entered!';
    }


}
