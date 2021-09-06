<?php

namespace App\Rules;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class CheckForValidInterviewerRule implements Rule
{

    protected $user_repository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_repository = App::make(UserRepositoryInterface::class);
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
        $team_leads = $this->user_repository->teamLeadsIds();
        return in_array($value, $team_leads);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This user does not exist or has not valid role to be interviewer!';
    }
}
