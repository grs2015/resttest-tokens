<?php

namespace App\Http\Controllers\Producer;

use App\Models\Producer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProducerOrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producer $producer)
    {
        $orderItems = $producer->products()->with('order_items')->get()
            ->pluck('order_items')->collapse()->sortBy('id')
            ->unique('id')->values();

        return $this->showAll($orderItems);
    }
}
