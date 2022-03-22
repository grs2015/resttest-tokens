<?php

namespace App\Http\Controllers\Region;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $products = $region->customers()->with('orders.order_items.product')->get()
            ->pluck('orders')->collapse()
            ->pluck('order_items')->collapse()
            ->pluck('product')->sortBy('id')->unique('id')->values();

        return $this->showAll($products, Response::HTTP_OK);
    }
}
