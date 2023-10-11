<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use App\Models\FurnitureCategory;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class FurnitureCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $furnitures = FurnitureCategory::all();
        return $furnitures;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FurnitureCategory::create($request->all());

        return Response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(FurnitureCategory $furnitureCategory)
    {
        return  $furnitureCategory;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FurnitureCategory $furnitureCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FurnitureCategory $furnitureCategory)
    {
        $furnitureCategory->delete();
    }
}
