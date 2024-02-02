<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Announcer;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            "furnitures"=>Ad::where("item_type",1)->count(),
            "houses" => Ad::where("item_type", 0)->count(),
            "announcers" => Announcer::count(),
            "verified_announcers"=>Announcer::where("verified",true)->count()
        ]);
    }
}
