<?php

namespace App\Http\Controllers\Producer;

use App\Models\Producer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProducerOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producer $producer)
    {
        $orders = $producer->products()->with('order_items.order')->get()
            ->pluck('order_items')->collapse()
            ->pluck('order')->sortBy('id')->unique('id')->values();

        return $this->showAll($orders);
    }
}
