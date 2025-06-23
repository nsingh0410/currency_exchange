<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LandingService;

class LandingController extends Controller
{
    protected $landingService;

    public function __construct(LandingService $landingService)
    {
        $this->landingService = $landingService;
    }

    public function index()
    {
        return response()->json($this->landingService->getLandingData());
    }
}