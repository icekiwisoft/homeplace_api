<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    //ad ad to favorite
    public function addToFavorites(Request $request, Ad $ad)
    {
        $user = $request->user();

        // Check if already added
        if ($user->favorites()->where('ad_id', $ad->id)->exists()) {
            return response()->json(['message' => 'Ad is already in your favorites'], 400);
        }

        // Add to favorites
        $user->favorites()->attach($ad->id);

        return response()->json(['message' => 'Ad added to favorites successfully'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function removeFromFavorites(Request $request, Ad $ad)
    {
        $user = $request->user();

        // Check if the ad is already in the user's favorites
        if (!$user->favorites()->where('ad_id', $ad->id)->exists()) {
            return response()->json(['message' => 'Ad is not in your favorites'], 400);
        }

        // Remove from favorites
        $user->favorites()->detach($ad->id);

        return response()->json(['message' => 'Ad removed from favorites successfully'], 200);
    }
}
