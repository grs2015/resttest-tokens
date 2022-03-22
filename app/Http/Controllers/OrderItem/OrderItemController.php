<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Events\OrderItemDeleted;
use App\Filters\OrderItemFilter;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItemFilter $filters)
    {
        $orderItems = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            fn() => OrderItem::filter($filters)->get()
        );

        return $this->showAll($orderItems, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderitem)
    {
        return $this->showOne($orderitem, Response::HTTP_OK);
    }

    public function destroy(OrderItem $orderitem)
    {
        $orderitem->delete();

        event(new OrderItemDeleted($orderitem));

        return $this->showOne($orderitem, Response::HTTP_OK);
    }
}
