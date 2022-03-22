<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $products = $customer->orders()->with('order_items.product')->get()
            ->pluck('order_items')->collapse()
            ->pluck('product')->sortBy('id')->unique('id')->values();

        return $this->showAll($products, Response::HTTP_OK);
    }
}
