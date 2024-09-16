<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;


class PaymentService
{

    protected $client;

    public function __construct()
    {

        $CAMPAY_URI = getenv('CAMPAY_ENDPOINT'); // ou mettez directement votre SID

    }

    /**
     * Process payment with Campay (mock implementation).
     */
    public function processPayment($phoneNumber, $amount, $paymentId, $method)
    {
        // Replace with actual Campay API integration

        $response = Http::withHeader("Authorization", "Token a215c8f4852e6a6b8b876b0874ac29f91d0679bf")->post('https://demo.campay.net/api/collect', [
            'amount' => $amount,
            "description" => "Test",
            "external_reference" => "",
            "from" => $phoneNumber,
        ]);


        if ($response->successful()) {
            return [
                'status' => 'success',
                'transaction_id' => $paymentId,
            ];
        }

        return [
            'status' => 'failed',
            'error' => 'Payment could not be processed',
        ];
    }
}
