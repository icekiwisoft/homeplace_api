<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Decoders\FilePathImageDecoder;
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
