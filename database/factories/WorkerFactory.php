<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Worker;
use App\Models\WorkerPosition;
use App\Models\WorkerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>$this->faker->name,
            "company_id"=>Company::all()->random()->id,
            "status_id"=>rand(WorkerStatus::all()->random()->id, 1),
            "position_id"=>WorkerPosition::all()->random()->id,
        ];
    }
}
