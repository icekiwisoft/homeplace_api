<?php

namespace App\Http\Controllers;

use App\Http\Resources\Adresource;
use App\Models\Media;


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
