<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryOrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $orderItems = $category->products()->with('order_items')->get()
            ->pluck('order_items')->collapse()
            ->sortBy('id')->unique('id')->values();

        return $this->showAll($orderItems);
    }
}
