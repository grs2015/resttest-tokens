<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Events\OrderItemCreated;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerProductOrderItemController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer, Product $product)
    {
        //NOTE Можно также реализовать функционал либо автоинкрементирования номера order,
        //либо произвольного выбора (как сейчас).

        //NOTE В общем метод излишний, так как фронт может поочередно вызывать методы create
        //контроллеров CustomerOrder и OrderProductOrderItem.

        $request->validate([
            'order_number' => ['required', 'regex:/\d{4}\/\d{2}/i', 'unique:orders'],
            'order_item_quantity' => 'required|integer|min:1'
        ]);

        $orderData = $request->only(['order_number']);
        $orderData['order_date'] = now()->toDateString();
        $orderData['customer_id'] = $customer->id;
        $order = Order::create($orderData);

        $orderItemData = $request->only(['order_item_quantity']);
        $orderItemData['order_id'] = $order->id;
        $orderItemData['product_id'] = $product->id;
        $orderItemData['order_item_sum'] = $product->price * $orderItemData['order_item_quantity'];

        $orderItem = OrderItem::create($orderItemData);

        event(new OrderItemCreated($orderItem));

        return $this->showOne($orderItem, Response::HTTP_CREATED);
    }
}
