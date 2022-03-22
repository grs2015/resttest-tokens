<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $orderitem)
    {
        $customers = $orderitem->order()
            ->with(['customer.region', 'customer.branch', 'customer.detail'])->get()
            ->pluck('customer');

        return $this->showAll($customers, Response::HTTP_OK);
    }
}
