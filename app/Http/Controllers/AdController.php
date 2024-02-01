<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Resources\Adresource;
use App\Http\Resources\AnnouncerResource;
use App\Models\Ad;
use App\Models\Announcer;
use App\Models\House;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//this controller handles all request related to ads

class AdController extends Controller
{

  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::all()->load("announcer");

        return  Adresource::collection($ads);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $id = $request->input("announcer", null);
        $validated= $request->validated();
       $ad= new Ad($validated);

       $announcer=Announcer::findOrFail($validated["announcer_id"]);
       $ad->announcer()->associate($announcer);

$ad->save();
        return new AdResource($ad);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {

        if (!$ad) {
            throw new NotFoundHttpException('Ad not found');
        }
        return new Adresource($ad);
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
        $ad->deleteOrFail();
        return response()->json();
    }
}
