<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $date = $this->faker->dateTimeThisMonth();
        return [
            'url' => $this->faker->url,
            'gender' => rand(0, 1),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
