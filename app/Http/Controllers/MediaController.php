<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Media;

class MediaController extends Controller
{

    public function index()
    {
        $medias = Media::all();
        return MediaResource::collection($medias);
    }
    /**
     * Display a listing of the resource.
     */
    public function show(Media $media)
    {
        return new  MediaResource($media);
    }
}
