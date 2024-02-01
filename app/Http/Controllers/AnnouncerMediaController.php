<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Announcer;
use App\Models\media;
use Illuminate\Http\Request;

class AnnouncerMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Announcer $announcer)
    {
        $medias = $announcer->medias()->get();
        return MediaResource::collection($medias);
    }
}
