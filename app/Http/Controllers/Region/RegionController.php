<?php

namespace App\Http\Controllers\Region;

use App\Filters\RegionFilter;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RegionFilter $filters, Request $request)
    {
        $regions = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime($request),
            fn() => Region::filter($filters)->get()
        );

        return $this->showAll($regions, Response::HTTP_OK, null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'region' => 'required|unique:regions|string'
        ]);

        $regionData = $request->only(['region']);
        $regionData['region_short'] = (explode(' ', $request->region))[0];

        $region = Region::create($regionData);

        return $this->showOne($region, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        return $this->showOne($region, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'region' => 'unique:regions|string'
        ]);

        $region->fill($request->only(['region']));

        if ($region->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $region->region_short = (explode(' ', $request->region))[0];
        $region->save();

        return $this->showOne($region, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return $this->showOne($region, Response::HTTP_OK);
    }
}
