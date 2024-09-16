<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Resources\PaymentResource;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::paginate(15); // Adjust the number per page as needed
        return PaymentResource::collection($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_type' => 'required|in:subscription,ad_unlock,other',
            'reference_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_id' => 'required|string|unique:payments,payment_id',
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::create($validated);

        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_type' => 'sometimes|in:subscription,ad_unlock,other',
            'reference_id' => 'sometimes|integer',
            'payment_method' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0',
            'payment_id' => 'sometimes|string',
            'status' => 'sometimes|in:pending,completed,failed',
        ]);

        $payment->update($validated);

        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully'], 204);
    }

    /**
     * Handle a payment process.
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_type' => 'required|in:subscription,ad_unlock',
            'reference_id' => 'required_if:payment_type,subscription|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_id' => 'required|string|unique:payments,payment_id',
        ]);

        // Example payment processing logic (integrate with actual payment gateway)
        $response = $this->mockPaymentGateway($validated);

        if ($response['status'] === 'success') {
            $payment = Payment::create([
                'user_id' => $validated['user_id'],
                'payment_type' => $validated['payment_type'],
                'reference_id' => $validated['reference_id'] ?? null,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_id' => $validated['payment_id'],
                'status' => 'completed',
            ]);

            // Additional logic based on payment type
            if ($validated['payment_type'] === 'subscription') {
                // Handle subscription activation or credit allocation
                $subscription = Subscription::find($validated['reference_id']);
                $subscription->update([
                    'active' => true,
                    'expires_at' => now()->addDays($subscription->duration),
                ]);
            } elseif ($validated['payment_type'] === 'ad_unlock') {
                // Handle ad unlocks if needed
                // ...
            }

            return new PaymentResource($payment);
        }

        return response()->json(['message' => 'Payment processing failed', 'error' => $response['error']], 400);
    }


}
