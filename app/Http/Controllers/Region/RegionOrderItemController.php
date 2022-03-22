<?php

namespace App\Http\Controllers\Region;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionOrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $orderItems = $region->customers()->with('orders.order_items')->get()
            ->pluck('orders')->collapse()
            ->pluck('order_items')->collapse()->sortBy('id');

        return $this->showAll($orderItems, Response::HTTP_OK);
    }
}
