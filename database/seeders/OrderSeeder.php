<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::all()->each(function($customerItem) {
            $order = Order::factory()->count(random_int(1, 10))->make();
            $customerItem->orders()->saveMany($order);
        });
    }
}
