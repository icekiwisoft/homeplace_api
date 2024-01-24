<?php

namespace App\Http\Controllers;

use App\Models\Announcer;
use Illuminate\Http\Request;

class AnnouncerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $announcer = Announcer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone
            ]);
            return response()->json([$announcer], 201);
        }catch(Exception $e){
            return response()->json($e, 400);
        }

        // try {
        //     $an = new Announcer();
        //     $an->name = $request->name;
        //     $an->email = $request->email;
        //     $an->phone_number = $request->phone;
        //     $an->save();
        //     return response()->json([$an], 201);
        //       } catch (Exception $e) {
        //           return response()->json($e, 400);
        //       }


    }

    /**
     * Display the specified resource.
     */
    public function show(Announcer $announcer)
    {
        return $announcer;
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
        return Response()->json();
    }
}
