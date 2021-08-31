<?php

namespace Database\Factories;

use App\Models\Phone;
use App\Models\PhoneCountryCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "phone_number"=>$this->faker->phoneNumber,
            "phone_country_code_id"=>PhoneCountryCode::all()->random()->id,
        ];
    }
}
