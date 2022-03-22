<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $categories = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            function() use ($branch) {
                return $branch->customers()->with('orders.order_items.product.categories')->get()
                    ->pluck('orders')->collapse()
                    ->pluck('order_items')->collapse()
                    ->pluck('product.categories')->collapse()->sortBy('id')->unique('id')->values();
            });
        return $this->showAll($categories, Response::HTTP_OK);
    }
}
