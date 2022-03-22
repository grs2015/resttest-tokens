<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemProducerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $orderitem)
    {
        $producers = $orderitem->product()->with('producer')->get()
            ->pluck('producer');

        return $this->showAll($producers, Response::HTTP_OK);
    }
}
