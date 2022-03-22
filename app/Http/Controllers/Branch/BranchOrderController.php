<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $orders = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            function() use ($branch){
                return $branch->customers()->with('orders')->get()
                    ->pluck('orders')->collapse();
            });

        return $this->showAll($orders, Response::HTTP_OK);
    }
}
