<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\OrderItemCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountOrderItemsAfterCreate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderItemCreated  $event
     * @return void
     */
    public function handle(OrderItemCreated $event)
    {
        $order = Order::find($event->orderItem->order_id);
        $count = $order->loadCount('order_items')->order_items_count;
        $order->orderitems_count = $count;
        $order->order_sum += $event->orderItem->order_item_sum;
        $order->save();
    }
}
