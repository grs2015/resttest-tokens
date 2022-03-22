<?php

namespace App\Http\Controllers\Producer;

use App\Models\Producer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProducerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producer $producer)
    {
        $categories = $producer->products()
            ->with('categories')->get()
            ->pluck('categories')->collapse()
            ->sortBy('id')->unique('id')->values();

        return $this->showAll($categories);
    }
}
