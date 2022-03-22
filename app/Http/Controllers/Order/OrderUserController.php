<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OrderUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        $users = $order->customer()->with(['users' => function($query) {
            $query->where('purchase_role', User::PROCUREMENT_USER);
        }])->get()->pluck('users')->collapse();

        return $this->showAll($users, Response::HTTP_OK);
    }
}
