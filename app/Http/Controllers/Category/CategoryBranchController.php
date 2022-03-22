<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryBranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $branches = $category->products()
            ->with('order_items.order.customer.branch')->get()
            ->pluck('order_items')->collapse()
            ->pluck('order.customer.branch')->sortBy('id')
            ->unique('id')->values();

        return $this->showAll($branches);
    }
}
