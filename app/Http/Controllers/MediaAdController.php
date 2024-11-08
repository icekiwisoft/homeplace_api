<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\Adresource;
use App\Http\Resources\AnnouncerResource;
use App\Models\Media;
use App\Models\ad;
use App\Models\Announcer;
use Illuminate\Http\Request;

class MediaAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Media $media)
    {
        $ads = $media->ads()->paginate(15);
        return  Adresource::collection($ads);
    }
}
