<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $products = $branch->customers()->with('orders.order_items.product')->get()
            ->pluck('orders')->collapse()
            ->pluck('order_items')->collapse()
            ->pluck('product')->sortBy('id')->unique('id')->values();

        return $this->showAll($products, Response::HTTP_OK);
    }
}
