<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Resources\Adresource;
use App\Http\Resources\AnnouncerResource;
use App\Models\Ad;
use App\Models\Announcer;
use App\Models\House;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//this controller handles all request related to ads

class AdController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ad::query();

        if (request('search')) {
            $query->where(function (Builder $query) {
                $query->where('description', 'like', '%' . request('search') . '%')
                ->orWhere('price', 'like', '%' . request('search') . '%');
            });
        }
        if ($request->has(['type']) ) {
            $query->where('item_type',request('type'));
        }
        if ($request->has(['orderBy']) ) {
            $query->orderBy(request('orderBy'));
        }

        $ads = $query->paginate(10);

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
       if ($request->hasFile('presention')) {
        $filename = $ad->id.$request->file("presentation")->getExtension();
        $savedfile = $request->file("presentation")->storeAs('public/images/presentation', $filename);
        $ad->presentation_img=$savedfile;
    }

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
