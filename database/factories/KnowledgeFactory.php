<?php

namespace Database\Factories;

use App\Models\Knowledge;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Knowledge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year_start'=>$this->faker->year,
            'description'=>$this->faker->realText,
            'level_id'=>Level::all()->random()->id
        ];
    }
}
