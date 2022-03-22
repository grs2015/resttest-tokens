<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderFilter $filters)
    {
        $orders = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            fn() => Order::filter($filters)->get()
        );

        return $this->showAll($orders, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = $order->with('customer')->get()->first();
        return $this->showOne($order, Response::HTTP_OK);
    }
}
