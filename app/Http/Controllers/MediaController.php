<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\Media;
use Exception;
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
        $path = storage_path('app/upload/' . $media->file);
        if (file_exists($path)) {
            // return response()->file($path);
            return $media;
        }
    }


    public function store(StoreMediaRequest $request)
    {
        try {
            $fichier = $request->file('file');
            // Supprimer les espaces dans le nom de fichier
            $filename = str_replace(' ', '', $fichier->getClientOriginalName());
            // dd($filename);
            $extension = $fichier->getClientOriginalExtension();
            // get file size in byte
            $fichier_save = $request->file->storeAs('upload', $filename);
            $img = new Media();
            $img->file = $fichier->getClientOriginalName();
            $img->description = $request->description;
            $img->save();

            return response()->json([$img], 201);
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }

    public function update(Request $request, Media $media)
    {
        dd($request->file);
        // try {
            // dd($media);
            $img = new Media();
            $imgs = $request->input('file');
            dd($imgs);
            // $media->description = $request->description;
            $filename = str_replace(' ', '', $imgs->getClientOriginalName());
            dd($img);
            $fichier_save = $request->file->storeAs('upload', $filename);
            
            dd($img);
            $img->file = $request->getClientOriginalName();
            $img->description = $request->description;
            dd($img);

            $media->save();
            dd($media);
            // $img = new Media();
            // $img->file = $request->getClientOriginalName();
            // $img->description = $request->description;
            // dd($img);
            // $img->save();
            return response()->json($img, 201);
        // } catch (Exception $e) {
        //     return response()->json($e);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json([], 201);
    }
}
