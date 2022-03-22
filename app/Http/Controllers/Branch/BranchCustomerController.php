<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $customers = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            function() use ($branch){
                return $branch->customers()->with(['region', 'detail'])->get();
            });

        return $this->showAll($customers, Response::HTTP_OK);
    }
}
