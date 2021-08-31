<?php

namespace Database\Factories;

use App\Models\Interview;
use App\Models\InterviewStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $team_leads = Role::find(3)->users->modelKeys();

        return [
            "link"=>'https://meet.google/'.$this->faker->word,
            "interview_time"=>$this->faker->dateTimeBetween('+2days', '+2weeks'),
            "description"=>$this->faker->realText,
            "interviewer_id"=>$team_leads[array_rand($team_leads)],
            "status_id"=> InterviewStatus::all()->random()->id
        ];
    }
}
