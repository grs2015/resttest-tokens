<?php

namespace App\Http\Controllers\Producer;

use App\Models\Producer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProducerCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producer $producer)
    {
        $customers = $producer->products()->with('order_items.order.customer')->get()
            ->pluck('order_items')->collapse()
            ->pluck('order.customer')->sortBy('id')->unique('id')->values();

        return $this->showAll($customers);
    }
}
