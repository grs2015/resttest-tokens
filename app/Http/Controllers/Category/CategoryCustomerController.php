<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $customers = $category->products()
            ->with('order_items.order.customer')->get()
            ->pluck('order_items')->collapse()
            ->pluck('order.customer')->sortBy('id')
            ->unique('id')->values();

        return $this->showAll($customers);
    }
}
