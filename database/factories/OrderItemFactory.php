<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_item_quantity' => $qty = $this->faker->numberBetween(1, 5),
            'product_id' => $productId = Product::inRandomOrder()->first()->id,
            'order_item_sum' => Product::find($productId)->price * $qty,
        ];
    }
}
