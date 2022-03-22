<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $categories = $customer->orders()->with('order_items.product.categories')->get()
            ->pluck('order_items')->collapse()
            ->pluck('product.categories')->collapse()
            ->sortBy('id')->unique('id')->values();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}
