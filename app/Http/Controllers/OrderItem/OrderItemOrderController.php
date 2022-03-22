<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $orderitem)
    {
        $order = $orderitem->order;

        return $this->showOne($order, Response::HTTP_OK);
    }
}
