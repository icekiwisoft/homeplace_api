<?php

namespace App\Http\Controllers;

use App\Models\newsletter;
use Illuminate\Http\Request;


class NewsletterController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mail = newsletter::all();
        return $mail;
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AddEmailRequest $request)

    {
        try {
            $mail = new newsletter();
            $mail->email = $request->email;
            $mail->save();
            return response()->json([$mail], 201);
              } catch (Exception $e) {
                  return response()->json($e, 400);
              }
    }


    /**
     * Display the specified resource.
     */
    public function show(newsletter $newsletter)
    {

        return $newsletter;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(newsletter $newsletter)
    {
        //
    }
}
