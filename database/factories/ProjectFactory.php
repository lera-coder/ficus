<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>$this->faker->sentence($nbWords = 4, $variableNbWords = true),
            "description"=>$this->faker->realText,
            "price"=>rand(10000, 1000000),
            "status_id"=>rand(1, ProjectStatus::all()->count() - 1),
        ];
    }
}
