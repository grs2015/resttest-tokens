<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerOrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $orderItems = $customer->orders()->with('order_items')->get()
            ->pluck('order_items')->collapse();

        return $this->showAll($orderItems, Response::HTTP_OK);
    }
}
