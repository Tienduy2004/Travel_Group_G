<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayOSService
{
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.payos.api_key');
        $this->secretKey = config('services.payos.secret_key');
        $this->baseUrl = config('services.payos.base_url');
    }

    public function createPayment($orderId, $amount)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/v1/payments", [
            'order_id' => $orderId,
            'amount' => $amount,
            'currency' => 'VND',
            'description' => 'Thanh toán tour du lịch',
            'return_url' => route('booking.success'),
            'cancel_url' => route('booking.cancel'),
        ]);

        return $response->json();
    }
}
