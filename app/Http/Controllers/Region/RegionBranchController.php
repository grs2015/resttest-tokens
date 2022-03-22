<?php

namespace App\Http\Controllers\Region;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionBranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $branches = $region->customers()->with('branch')->get()
            ->pluck('branch')->sortBy('id')->unique('id')->values();

        return $this->showAll($branches, Response::HTTP_OK);
    }
}
