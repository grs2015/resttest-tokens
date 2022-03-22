<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Producer;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producer::all()->each(function($producerItem) {
            $product = Product::factory()->count(random_int(1, 10))->make();
            $producerItem->products()->saveMany($product);
        });

        Product::all()->each(function($productItem) {
            $categoriesId = Category::all()->random(random_int(1, 3))->pluck('id');
            $productItem->categories()->sync($categoriesId);
        });
    }
}
