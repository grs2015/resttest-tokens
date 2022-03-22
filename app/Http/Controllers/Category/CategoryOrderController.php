<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $orders = $category->products()->with('order_items.order')->get()
        ->pluck('order_items')->collapse()->pluck('order')
        ->sortBy('id')->unique('id')->values();

        return $this->showAll($orders);
    }
}
