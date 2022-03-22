<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemRegionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $orderitem)
    {
        $regions = $orderitem->order()->with('customer.region')->get()
            ->pluck('customer.region');

        return $this->showAll($regions, Response::HTTP_OK);
    }
}
