<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Events\OrderItemCreated;
use App\Events\OrderItemDeleted;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrderProductOrderItemController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order, Product $product)
    {
        $request->validate([
            'order_item_quantity' => 'required|integer|min:1'
        ]);

        $orderItemData = $request->only(['order_item_quantity']);

        $orderItemData['order_id'] = $order->id;
        $orderItemData['product_id'] = $product->id;
        $orderItemData['order_item_sum'] = $product->price * $orderItemData['order_item_quantity'];

        $orderItem = OrderItem::create($orderItemData);

        event(new OrderItemCreated($orderItem));

        return $this->showOne($orderItem, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, Product $product, OrderItem $orderitem)
    {
        $request->validate([
            'order_item_quantity' => 'required|integer|min:1'
        ]);

        $this->checkConditions($order, $product, $orderitem);

        $orderitem->fill($request->only(['order_item_quantity']));
        $orderitem->order_item_sum = $product->price * $request->order_item_quantity;

        if ($orderitem->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $orderitem->save();

        return $this->showOne($orderitem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, Product $product, OrderItem $orderitem)
    {
        $this->checkConditions($order, $product, $orderitem);

        $orderitem->delete();

        event(new OrderItemDeleted($orderitem));

        return $this->showOne($orderitem);
    }

    public function checkConditions(Order $order, Product $product, OrderItem $orderitem) {
        if ($order->id != $orderitem->order_id) {
            throw new HttpException(422, 'The specified order/producer are not the actual order/product of the order item');
        }
    }
}
