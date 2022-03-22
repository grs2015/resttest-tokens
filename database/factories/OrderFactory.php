<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_number' => $this->faker->unique()->numerify('####/##'),
            'order_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'orderitems_count' => $this->faker->numberBetween(1, 7)
        ];
    }
}
