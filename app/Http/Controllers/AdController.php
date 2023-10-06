<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


//this controller handles all request related to ads

class AdController extends Controller
{

  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::all();

        return $ads;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // On crée un nouvel utilisateur
        $ad = Ad::create([
            'description' => $request->description
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return $ad;
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {

        return $ad;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {

        // La validation de données


        $ad->update([
            'description' => $request->description
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return response()->json();
    }
}
