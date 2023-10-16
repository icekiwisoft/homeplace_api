<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $fichier = Media::find($id);
        // dd($fichier);
        if ($fichier) {
            $path = storage_path('app/upload/' . $fichier->file);
            if (file_exists($path)) {
                return response()->json(['media' => $path], 200);
            }else{
                return response()->json(['message' => 'fichier pas vu'], 404);
            };
        }else{
            return response()->json(['message' => 'fichier not found.'], 404);
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
        {
            try{
                $fichier = $request->file('file');
                // Supprimer les espaces dans le nom de fichier
                $filename = str_replace(' ', '', $fichier->getClientOriginalName());
                
                $extension = $fichier->getClientOriginalExtension();
                // Récupérer la taille du fichier en bytes
                $size = $fichier->getSize();
                if($size >= 1000000){
                    return response()->json([
                        'status_code' => 422,
                        'status_message' => 'la taille du fichier doit etre inferieure a 1 Mo',
                    ]);
                }else{
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
            }catch(Exception $e){
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
    public function update(Request $request)
    {
        try{
            // $media->file = $request->input('file');
                // $media->description = $request->description;
                $media = Media::find($request->id);
                // $filename = str_replace(' ', '', $media->getClientOriginalName());
                if($request){
                    $fichier = $request->file('file');
                    $size = $fichier->getSize();
                    if($size >= 1000000){
                        return response()->json([
                            'status_code' => 422,
                            'status_message' => 'la taille du fichier doit etre inferieure a 1 Mo',
                        ]);
                    }else{
                        $filename = str_replace(' ', '', $fichier->getClientOriginalName());

                        $fichier_save = $request->file->storeAs('upload', $filename);
                        // $img = new Media();
                        $media->file = $filename;
                        $media->description = $request->description;
                        $media->save();
                        
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'fichier modifier avec succes',
                        'data' => $img
                    ]);
                    };
                }else{
                    return response()->json([
                        'status_code' => 422,
                        'status_message' => 'veuillez remplir les champs',
                    ]);
                };
        }catch(Exception $e){
                return response()->json($e);
           }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
     try{
            $media = Media::find($id);
            if( $media){
                    $media->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'media supprimer avec succes',
                ]);
            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'media introuvable!'
                ]);
            }
        }catch(Ecxeption $e){
            return response()->json($e);
        }
    }

}
