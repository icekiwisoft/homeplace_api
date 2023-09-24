<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Furniture::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $furniture = Furniture::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return $furniture;
    }

    /**
     * Display the specified resource.
     */
    public function show(Furniture $furniture)
    {
        return $furniture;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Furniture $furniture)
    {
        $furniture->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return $furniture;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Furniture $furniture)
    {
        return Response()->json();
    }
}
