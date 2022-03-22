<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchOrderItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $orderItems = $branch->customers()->with('orders.order_items')->get()
            ->pluck('orders')->collapse()
            ->pluck('order_items')->collapse()->sortBy('id');

        return $this->showAll($orderItems, Response::HTTP_OK);
    }
}
