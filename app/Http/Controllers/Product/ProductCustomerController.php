<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $customers = $product->order_items()->with('order.customer')->get()
            ->pluck('order.customer')->sortBy('id')->unique('id')->values();

        return $this->showAll($customers);
    }
}
