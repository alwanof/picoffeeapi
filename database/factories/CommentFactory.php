<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
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
            'body' => $this->faker->paragraph(1),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
