<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        $products = $order->order_items()->with('product.producer')->get()
            ->pluck('product')->sortBy('id')->unique('id')->values();

        return $this->showAll($products, Response::HTTP_OK);
    }
}
