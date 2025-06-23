<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function test_get_rates_returns_expected_structure()
    {
        // Fake the external API responses
        Http::fake([
            'https://open.er-api.com/v6/latest/USD' => Http::response(['rates' => ['AUD' => 1.55]], 200),
            'https://open.er-api.com/v6/latest/EUR' => Http::response(['rates' => ['AUD' => 1.6]], 200),
            'https://open.er-api.com/v6/latest/GBP' => Http::response(['rates' => ['AUD' => 1.8]], 200),
            'https://open.er-api.com/v6/latest/JPY' => Http::response(['rates' => ['AUD' => 0.01]], 200),
        ]);

        $response = $this->getJson('/api/currency/rates');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'timestamp',
                     'AUD',
                     'USD',
                     'EUR',
                     'GBP',
                     'JPY',
                 ])
                 ->assertJson([
                     'AUD' => 1.0,
                     'USD' => 1.55,
                     'EUR' => 1.6,
                     'GBP' => 1.8,
                     'JPY' => 0.01,
                 ]);
    }

    public function test_get_rates_handles_failed_api_call()
    {
        Http::fake([
            'https://open.er-api.com/v6/latest/USD' => Http::response([], 500),
            'https://open.er-api.com/v6/latest/EUR' => Http::response(['rates' => ['AUD' => 1.6]], 200),
            'https://open.er-api.com/v6/latest/GBP' => Http::response(['rates' => ['AUD' => 1.8]], 200),
            'https://open.er-api.com/v6/latest/JPY' => Http::response(['rates' => ['AUD' => 0.01]], 200),
        ]);

        $response = $this->getJson('/api/currency/rates');

        $response->assertStatus(200)
                 ->assertJson([
                     'USD' => null,
                     'EUR' => 1.6,
                     'GBP' => 1.8,
                     'JPY' => 0.01,
                 ]);
    }
}
