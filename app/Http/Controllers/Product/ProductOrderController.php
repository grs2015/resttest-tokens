<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ProductOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $orders = $product->order_items()->with('order')->get()
            ->pluck('order')->sortBy('id')->unique('id')->values();

        return $this->showAll($orders, Response::HTTP_OK);
    }
}
