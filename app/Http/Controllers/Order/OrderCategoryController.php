<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        $categories = $order->order_items()->with('product.categories')->get()
            ->pluck('product.categories')->collapse()->sortBy('id')->unique('id')->values();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}
