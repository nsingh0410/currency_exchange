<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LandingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;

class LandingController extends Controller
{
    protected $landingService;

    public function __construct(LandingService $landingService)
    {
        $this->landingService = $landingService;
    }

    public function index(): JsonResponse
    {
        Log::info('LandingController@index called');

        try {
            $data = $this->landingService->getLandingData();
            Log::info('Landing data retrieved successfully', ['data' => $data]);

            return response()->json($data);
        } catch (Exception $e) {
            Log::error('Error retrieving landing data', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to retrieve landing data'], 500);
        }
    }
}
