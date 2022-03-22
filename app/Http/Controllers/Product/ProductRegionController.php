<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductRegionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $regions = $product->order_items()->with('order.customer')->get()
            ->pluck('order.customer.region')->sortBy('id')->unique('id')->values();

        return $this->showAll($regions, Response::HTTP_OK);
    }
}
