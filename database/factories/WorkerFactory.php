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
            "company_id"=>rand(1, Company::all()->count()),
            "status_id"=>rand(rand(1, WorkerStatus::all()->count()), 1),
            "position_id"=>rand(1, WorkerPosition::all()->count()),
        ];
    }
}
