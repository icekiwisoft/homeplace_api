<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    public function __construct(protected PaymentService $paymentService) {}

    /**
     * List all subscriptions for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $subscriptions = Subscription::where('user_id', $user->id)->get();

        return response()->json($subscriptions);
    }

    /**
     * Subscribe a user to a plan.
     */
    public function store(Request $request)
    {

        $this->paymentService->processPayment("672005934", 20, 8, "mtn");
        $validated = $request->validate([
            'plan_name' => 'required|string|exists:subscription_plans,name',
        ]);

        $user = $request->user();

        // Retrieve the subscription plan by name
        $subscriptionPlan = SubscriptionPlan::where('name', $validated['plan_name'])->firstOrFail();

        // Create a new subscription for the user


        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $subscriptionPlan->id,
            'credits' => $this->getCreditsForPlan($subscriptionPlan->name),
            'price' => $this->getPriceForPlan($subscriptionPlan->name),
            'duration' => $this->getDurationForPlan($subscriptionPlan->name),
            'expires_at' => now()->addDays($this->getDurationForPlan($subscriptionPlan->name)),
        ]);

        return response()->json(['message' => 'Subscription successful', 'subscription' => $subscription], 201);
    }

    /**
     * Show a specific subscription for the authenticated user.
     */
    public function show(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($subscription);
    }

    /**
     * Cancel a subscription (soft delete).
     */
    public function destroy(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $subscription->delete();

        return response()->json(['message' => 'Subscription cancelled successfully'], 200);
    }

    /**
     * Get credits based on the subscription plan name.
     */
    private function getCreditsForPlan($planName)
    {
        switch ($planName) {
            case 'Standard':
                return 20;
            case 'Avantage':
                return 50;
            case 'Premium':
                return 100;
            case 'Ultime':
                return 250;
            default:
                return 0;
        }
    }

    /**
     * Get price based on the subscription plan name.
     */
    private function getPriceForPlan($planName)
    {
        switch ($planName) {
            case 'Standard':
                return 10.00;
            case 'Avantage':
                return 25.00;
            case 'Premium':
                return 45.00;
            case 'Ultime':
                return 90.00;
            default:
                return 0.00;
        }
    }

    /**
     * Get duration in days based on the subscription plan name.
     */
    private function getDurationForPlan($planName)
    {
        switch ($planName) {
            case 'Standard':
                return 3;
            case 'Avantage':
                return 7;
            case 'Premium':
                return 14;
            case 'Ultime':
                return 30;
            default:
                return 0;
        }
    }
}
