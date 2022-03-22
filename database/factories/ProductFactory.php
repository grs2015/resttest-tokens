<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = \Arr::random(['PRIZMA', 'VEKTOR', 'ET', 'ETL', 'MAVOWATT', 'SECUTEST']);

        return [
            'title' => $title = $this->faker->unique()->numerify($product . '-###'),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([Product::UNAVAILABLE_PRODUCT, Product::AVAILABLE_PRODUCT]),
            'image' => $this->faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'price' => $this->faker->numberBetween(3000, 30000),
            'slug' => Str::slug(strtolower($title))
        ];
    }
}
