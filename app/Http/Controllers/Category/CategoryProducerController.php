<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProducerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $producers = $category->products()
            ->with('producer')->get()
            ->pluck('producer')->sortBy('id')
            ->unique('id')->values();

        return $this->showAll($producers);
    }
}
