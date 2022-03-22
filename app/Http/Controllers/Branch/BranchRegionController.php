<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchRegionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        $regions = $branch->customers()->with('region')->get()
            ->pluck('region')->sortBy('id')->unique('id')->values();

        return $this->showAll($regions, Response::HTTP_OK);
    }
}
