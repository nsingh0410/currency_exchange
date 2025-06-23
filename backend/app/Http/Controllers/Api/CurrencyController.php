<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currency/rates",
     *     summary="Get live currency exchange rates",
     *     tags={"Currency"},
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     */
    public function getRates()
    {
        $currencies = ['USD', 'EUR', 'GBP', 'JPY'];
        $result = [
            'timestamp' => now()->toTimeString(),
            'AUD' => 1.0 // Static reference
        ];

        Log::info('Fetching AUD exchange rates', ['timestamp' => $result['timestamp']]);

        foreach ($currencies as $currency) {
            $url = "https://open.er-api.com/v6/latest/{$currency}";
            Log::info("Requesting rate from: {$url}");

            $response = Http::get($url);

            if ($response->successful()) {
                $rate = $response->json('rates.AUD');
                $result[$currency] = $rate;
                Log::info("Received rate", ['base' => $currency, 'AUD' => $rate]);
            } else {
                $result[$currency] = null;
                Log::warning("Failed to fetch rate", [
                    'base' => $currency,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        }

        Log::info('Final exchange result:', $result);

        return response()->json($result);
    }
}
