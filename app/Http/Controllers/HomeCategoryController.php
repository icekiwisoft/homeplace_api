<?php

namespace App\Http\Controllers;

use App\Models\HomeCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class HomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeCategory $homeCategory)
    {
        return $homeCategory;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeCategory $homeCategory)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeCategory $homeCategory)
    {
        //
    }
}
