<?php

namespace App\Http\Controllers\Customer;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class CustomerBranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $branch = $customer->branch;

        return $this->showOne($branch, Response::HTTP_OK);
    }
}
