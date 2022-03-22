<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ProductBranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $branches = $product->order_items()->with('order.customer')->get()
            ->pluck('order.customer.branch')->sortBy('id')->unique('id')->values();

        return $this->showAll($branches, Response::HTTP_OK);
    }
}
