<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerProducerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $producers = $customer->orders()->with('order_items.product.producer')->get()
            ->pluck('order_items')->collapse()
            ->pluck('product.producer')->sortBy('id')->unique('id')->values();

        return $this->showAll($producers, Response::HTTP_OK);
    }
}
