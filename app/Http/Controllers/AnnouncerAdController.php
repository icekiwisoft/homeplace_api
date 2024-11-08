<?php

namespace App\Http\Controllers;

use App\Http\Resources\Adresource;
use App\Http\Resources\AnnouncerResource;
use App\Models\Announcer;
use App\Models\ad;
use Illuminate\Http\Request;

class AnnouncerAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Announcer $announcer)
    {
        $ads = $announcer->ads()->paginate(15);
        return  Adresource::collection($ads);
    }
}
