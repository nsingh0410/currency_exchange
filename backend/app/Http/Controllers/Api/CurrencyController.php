<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function getRates()
    {
        $currencies = ['USD', 'EUR', 'GBP', 'JPY'];
        $result = [
            'timestamp' => now()->toTimeString(),
            'AUD' => 1.0 // Static reference
        ];

        foreach ($currencies as $currency) {
            $response = Http::get("https://open.er-api.com/v6/latest/{$currency}");

            if ($response->successful()) {
                $rate = $response->json('rates.AUD');
                $result[$currency] = $rate;
            } else {
                $result[$currency] = null;
            }
        }

        return response()->json($result);
    }
}
