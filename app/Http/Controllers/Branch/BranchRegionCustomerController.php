<?php

namespace App\Http\Controllers\Branch;

use App\Models\Branch;
use App\Models\Detail;
use App\Models\Region;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BranchRegionCustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch, Region $region)
    {
        $customers = Customer::where('branch_id', $branch->id)
                        ->where('region_id', $region->id)->without(['region', 'branch'])->get();

        return $this->showAll($customers, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Region $region)
    {
        $request->validate([
            'title' => 'required|unique:customers',
            'image' => 'image',
            'email' => 'email'
        ]);

        $slug = $this->getSlug($request->title);

        $detailData = $request->only(['description', 'phone', 'email', 'website']);
        $detailData['image'] = $request->hasFile('image')
            ? $request->image->store('', 'customers')
            : null;
        $detail = Detail::create($detailData);

        $customerData = $request->only(['title']);
        $customerData['detail_id'] = $detail->id;
        $customerData['branch_id'] = $branch->id;
        $customerData['region_id'] = $region->id;
        $customerData['slug'] = $slug;


        $customer = Customer::create($customerData);

        return $this->showOne($customer, Response::HTTP_CREATED);
    }

    protected function getSlug($title) {
        return Str::slug(trim(strtolower($title)));
    }
}
