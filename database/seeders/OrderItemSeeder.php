<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::all()->each(function($order) {
            $orderItem = OrderItem::factory()->count($order->orderitems_count)->make();
            $order->order_items()->saveMany($orderItem);
        });

        $orders = Order::withSum('order_items', 'order_item_sum')->get();

        foreach($orders as $order) {
            $order->order_sum = $order->order_items_sum_order_item_sum * $order->orderitems_count;
            $order->save();
        }
    }
}
