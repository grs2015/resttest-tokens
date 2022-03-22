<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryRegionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $regions = $category->products()
            ->with('order_items.order.customer.region')->get()
            ->pluck('order_items')->collapse()
            ->pluck('order.customer.region')->sortBy('id')
            ->unique('id')->values();

        return $this->showAll($regions);
    }
}
