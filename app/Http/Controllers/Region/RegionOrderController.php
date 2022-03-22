<?php

namespace App\Http\Controllers\Region;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $orders = $region->customers()->with('orders')->get()
            ->pluck('orders')->collapse();

        return $this->showAll($orders, Response::HTTP_OK);
    }
}
