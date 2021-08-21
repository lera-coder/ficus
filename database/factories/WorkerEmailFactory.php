<?php

namespace Database\Factories;

use App\Models\WorkerEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkerEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "email"=>$this->faker->email
        ];
    }
}
