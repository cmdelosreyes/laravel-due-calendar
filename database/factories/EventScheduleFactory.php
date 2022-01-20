<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->unique()->date('Y-m-d')
        ];
    }
}
