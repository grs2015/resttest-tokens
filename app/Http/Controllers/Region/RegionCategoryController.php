<?php

namespace App\Http\Controllers\Region;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $categories = $region->customers()->with('orders.order_items.product.categories')->get()
            ->pluck('orders')->collapse()
            ->pluck('order_items')->collapse()
            ->pluck('product.categories')->collapse()->sortBy('id')->unique('id')->values();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}
