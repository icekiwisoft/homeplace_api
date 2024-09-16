<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Resources\Adresource;
use App\Models\Ad;
use App\Models\Announcer;
use App\Models\Subscription;
use App\Models\Unlocking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

//this controller handles all request related to ads

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ad::query();

        if (request('search')) {
            $query->where(function (Builder $query) {
                $query->where('description', 'like', '%' . request('search') . '%')
                    ->orWhere('price', 'like', '%' . request('search') . '%');
            });
        }
        if ($request->has(['type'])) {
            $query->where('item_type', request('type'));
        }
        if ($request->has(['orderBy'])) {
            $query->orderBy(request('orderBy'));
        }
        // Filter ads liked by authenticated user
        if ($request->has(['liked'])) {
            $user = $request->user();
            $query->whereIn('id', $user->favorites()->pluck('ad_id'));
        }

        // Filter by budget
        if ($request->filled('budget_min') && $request->filled('budget_max')) {
            $query->whereBetween('price', [$request->budget_min, $request->budget_max]);
        } elseif ($request->filled('budget_min')) {
            $query->where('price', '>=', $request->budget_min);
        } elseif ($request->filled('budget_max')) {
            $query->where('price', '<=', $request->budget_max);
        }

        // Filter ads unlocked by authenticated user
        if ($request->user()) {
            $user = $request->user();
            $query->whereIn('id', $user->unlockedAds->pluck('ad_id'));
        }

        $ads = $query->paginate(10);

        return  Adresource::collection($ads);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $id = $request->input("announcer", null);
        $validated = $request->validated();
        $ad = new Ad($validated);
        if ($request->hasFile('presention')) {
            $filename = $ad->id . $request->file("presentation")->getExtension();
            $savedfile = $request->file("presentation")->storeAs('public/images/presentation', $filename);
            $ad->presentation_img = $savedfile;
        }

        $announcer = Announcer::findOrFail($validated["announcer_id"]);
        $ad->announcer()->associate($announcer);

        $ad->save();
        return new AdResource($ad);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        return new Adresource($ad);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {

        // La validation de données


        $ad->update([
            'description' => $request->description
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json();
    }


    /**
     * Check if house information is unlocked for the user.
     */
    public function isUnlocked(Request $request, $houseId)
    {
        $user = $request->user();

        $unlocking = Unlocking::where('user_id', $user->id)
            ->where('house_id', $houseId)
            ->first();

        if ($unlocking && !$unlocking->isExpired()) {
            return response()->json(['message' => 'House information is unlocked'], 200);
        }

        return response()->json(['message' => 'House information is not unlocked'], 403);
    }

    /**
     * Unlock house information for a user for 7 days.
     */
    public function unlock(Request $request, $houseId)
    {

        $user = $request->user();

        $existingUnlocking = Unlocking::where('user_id', $user->id)
            ->where('house_id', $houseId)
            ->first();

        if ($existingUnlocking && !$existingUnlocking->isExpired()) {
            return response()->json(['message' => 'House information already unlocked'], 200);
        }

        $subscription = Subscription::getActiveSubscription($user->id);

        if (!$subscription) {
            return response()->json(['message' => 'No valid subscription with sufficient credits'], 403);
        }

        $subscription->deductCredit();

        $unlocking = Unlocking::updateOrCreate(
            ['user_id' => $user->id, 'house_id' => $houseId],
            [
                'unlocked_at' => now(),
                'expires_at' => now()->addDays(7),
            ]
        );

        return response()->json(['message' => 'House information unlocked successfully', 'unlocking' => $unlocking], 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $ad->deleteOrFail();
        return response()->json();
    }
}
