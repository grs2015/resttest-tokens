<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Filters\BranchFilter;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BranchFilter $filters, Request $request)
    {
        $branches = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime($request),
            function() use ($filters){
                return Branch::filter($filters)->get();
            }
        );

        return $this->showAll($branches, Response::HTTP_OK, null);
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
            'branch' => 'required|unique:branches|string'
        ]);

        $branchData = $request->only(['branch']);
        $branchData['branch_short'] = (explode(' ', $request->branch))[0];
        $branch = Branch::create($branchData);

        return $this->showOne($branch, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        return $this->showOne($branch, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'branch' => 'unique:branches|string'
        ]);

        $branch->fill($request->only(['branch']));

        if ($branch->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $branch->branch_short = (explode(' ', $request->branch))[0];
        $branch->save();

        return $this->showOne($branch, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return $this->showOne($branch, Response::HTTP_OK);
    }
}
