<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncerRequest;
use App\Http\Resources\AnnouncerResource;
use App\Models\Announcer;
use Illuminate\Http\Request;

class AnnouncerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annoncers = Announcer::paginate(10);
        return AnnouncerResource::collection($annoncers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncerRequest $request)
    {
        $announcer = Announcer::create($request->safe()->except(['avatar']));
        if ($request->hasFile('avatar')) {
            $filename = $announcer->id.'.'.$request->file("avatar")->guessClientExtension();
            $savedfile = $request->file('avatar')->storeAs('public/images', $filename);
            $announcer->avatar=$savedfile;
            $announcer->save();
        }


        return new AnnouncerResource($announcer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcer $announcer)
    {
        return new AnnouncerResource($announcer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcer $announcer)
    {
        $announcer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcer $announcer)
    {
        $announcer->delete();
        return Response()->json(null, 200);
    }
}
