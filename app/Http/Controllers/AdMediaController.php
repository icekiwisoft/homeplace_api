<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Ad;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Ad $ad)
    {
        $medias = $ad->medias()->get();
        return MediaResource::collection($medias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ad $ad)
    {

        if ($request->hasFile("medias")) {
            $medias = new Collection();
            foreach ($request->medias as $file) {
                $img = new Media();
               $img->file=$file;
                $img->save();
                $medias->push($img);
            }
            $ad->medias()->syncWithoutDetaching($medias);
            return MediaResource::collection($medias);
        }

        if ($request->filled("filesid")) {
            $filesid = $request->collect("filesid");
            $attached = $ad->medias()->syncWithoutDetaching($filesid);
            $medias= Media::whereIn("id", $attached["attached"])->get();

            return MediaResource::collection($medias) ;
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad, Media $media)
    {
        $ad->media()->detach($media);
    }
}
