<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
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
            'tweet' => $this->faker->paragraph(rand(1, 3)),
            'user_id' => \App\Models\User::all()->random()->id,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
