<?php

namespace App\Http\Controllers\OrderItem;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $orderitem)
    {
        $categories = $orderitem->product()->with('categories')->get()
            ->pluck('categories')->collapse();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}
