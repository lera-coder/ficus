<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class LoginRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validator = str_contains($value, '@') ?
            Validator::make([$attribute => $value], ['login' => 'exists:emails,email']) :
            Validator::make([$attribute => $value], ['login' => 'exists:users,login']);
        return !$validator->fails();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Login/Email is not existed';
    }
}
