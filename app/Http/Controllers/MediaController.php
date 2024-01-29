<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function index()
    {

        $medias = Media::all();
        return $medias;
    }

    /**
     * Display a listing of the resource.
     */
    public function show(Media $media)
    {
        $fichier = Media::find($id);
        // dd($fichier);
        if ($fichier) {
            $path = storage_path('app/upload/' . $fichier->file);
            if (file_exists($path)) {
                return response()->file($path);
            } else {
                return response()->json(['message' => 'fichier pas vu'], 404);
            };
        } else {
            return response()->json(['message' => 'fichier not found.'], 404);
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $fichier = $request->file('file');
            // Supprimer les espaces dans le nom de fichier
            $filename = str_replace(' ', '', $fichier->getClientOriginalName());

            $extension = $fichier->getClientOriginalExtension();
            // Récupérer la taille du fichier en bytes
            $size = $fichier->getSize();
            if ($size >= 1000000) {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'la taille du fichier doit etre inferieure a 1 Mo',
                ]);
            } else {
                $fichier_save = $request->file->storeAs('upload', $filename);
                $img = new Media();
                $img->file = $fichier->getClientOriginalName();
                $img->description = $request->description;
                $img->save();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'fichier ajouter avec succes',
                    'data' => $img
                ]);
            };
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    // // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Media $media)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Media $media)
    // {
    //     //
    // }
    //
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        try {
            $media->file = $request->input('file');
            $media->description = $request->description;
            $filename = str_replace(' ', '', $media->getClientOriginalName());
            if ($media->file !=  null && $media->description != null) {
                $size = $media->getSize();
                if ($size >= 1000000) {
                    return response()->json([
                        'status_code' => 422,
                        'status_message' => 'la taille du fichier doit etre inferieure a 1 Mo',
                    ]);
                } else {
                    $fichier_save = $request->file->storeAs('upload', $filename);
                    // $img = new Media();
                    $media->file = $request->getClientOriginalName();
                    $media->description = $request->description;
                    $media->save();

                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'fichier modifier avec succes',
                        'data' => $img
                    ]);
                };
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'veuillez remplir les champs',
                ]);
            };
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Media $media)
    {
        try {
            // $pos = post::find($request->post_id);
            if ($media) {
                // if($pos->user_id == auth()->user()->id){
                $media->delete();
                // }else{
                //     return response()->json([
                //         'status_code' => 422,
                //         'status_message' => 'vous n\'avez pas le droit de modifier cette image',
                //     ]);
                //     }
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'media supprimer avec succes',
                    'data' => $media
                ]);
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'media introuvable!'
                ]);
            }
        } catch (Ecxeption $e) {
            return response()->json($e);
        }
    }
}
