<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Resources\Adresource;
use App\Models\Ad;
use App\Models\Furniture;
use App\Models\RealEstate;
use App\Models\Announcer;
use App\Models\Media;
use App\Models\Subscription;
use App\Models\Unlocking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ad::query();

        if ($request->has('search')) {
            $query->where(function (Builder $query) {
                $query->where('description', 'like', '%' . request('search') . '%')
                    ->orWhere('price', 'like', '%' . request('search') . '%');
            });
        }

        // Filter by item type (furniture or real estate)
        if ($request->has('type')) {
            $query->where('adable_type', $request->type == 'furniture' ? Furniture::class : RealEstate::class);
        }

        if ($request->has('orderBy')) {
            $query->orderBy($request->orderBy);
        }

        // Filter ads liked by authenticated user
        if ($request->has('liked')) {
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

        $ads = $query->with('adable')->paginate(20);

        return AdResource::collection($ads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $validated = $request->validated();
        $adable = null;

        // Check if the ad is for furniture or real estate and create accordingly
        if ($request->type == 'furniture') {
            $adable = Furniture::create($validated);
        } elseif ($request->type == 'realestate') {
            $adable = RealEstate::create($validated);
        }
        // Create ad and associate it with the specific ad type
        $ad = new Ad($validated);
        $announcer = $request->user()->announcer;

        $ad->announcer()->associate($announcer);

        $adable->ad()->save($ad);
        if ($request->hasFile("medias")) {
            $medias = new Collection();
            foreach ($request->medias as $file) {
                $img = new Media();
                $mimetype = $file->getMimeType();
                $filename = date("d_m_y") . "---" . $file->hashName();
                $savedfile = $file->storeAs('public/medias', $filename);
                $img->file = $savedfile;
                $img->type = $mimetype;
                $img->announcer()->associate($ad->announcer);
                $img->save();
                $medias->push($img);
            }
            $ad->medias()->syncWithoutDetaching($medias);
        }

        if ($request->filled("filesid")) {
            $filesid = $request->collect("filesid");
            $attached = $ad->medias()->syncWithoutDetaching($filesid);
            $medias = Media::whereIn("id", $attached["attached"])->get();
        }

        $ad->save();

        return new AdResource($ad);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        $ad->load('adable'); // Load the related furniture or real estate
        return new AdResource($ad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $ad->update([
            'description' => $request->description,
            'price' => $request->price
        ]);

        // Update specific adable fields based on type (furniture or real estate)
        if ($ad->adable_type == Furniture::class) {
            $ad->adable->update($request->only(['height', 'width', 'length', 'weight']));
        } elseif ($ad->adable_type == RealEstate::class) {
            $ad->adable->update($request->only(['toilet', 'kitchen', 'bedroom', 'mainroom']));
        }

        return new AdResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $ad->adable->delete(); // Delete related adable (furniture or real estate)
        $ad->delete(); // Then delete the ad itself
        return response()->json(null, 204);
    }

    /**
     * Check if the ad information is unlocked for the user.
     */
    public function isUnlocked(Request $request, $adId)
    {
        $user = $request->user();
        $unlocking = Unlocking::where('user_id', $user->id)
            ->where('ad_id', $adId)
            ->first();

        if ($unlocking && !$unlocking->isExpired()) {
            return response()->json(['message' => 'Ad information is unlocked'], 200);
        }

        return response()->json(['message' => 'Ad information is not unlocked'], 403);
    }

    /**
     * Unlock ad information for a user for 7 days.
     */
    public function unlock(Request $request, $adId)
    {
        $user = $request->user();

        $existingUnlocking = Unlocking::where('user_id', $user->id)
            ->where('ad_id', $adId)
            ->first();

        if ($existingUnlocking && !$existingUnlocking->isExpired()) {
            return response()->json(['message' => 'Ad information already unlocked'], 200);
        }

        $subscription = Subscription::getActiveSubscription($user->id);

        if (!$subscription) {
            return response()->json(['message' => 'No valid subscription with sufficient credits'], 403);
        }

        $subscription->deductCredit();

        $unlocking = Unlocking::updateOrCreate(
            ['user_id' => $user->id, 'ad_id' => $adId],
            [
                'unlocked_at' => now(),
                'expires_at' => now()->addDays(7),
            ]
        );

        return response()->json(['message' => 'Ad information unlocked successfully', 'unlocking' => $unlocking], 201);
    }
}
