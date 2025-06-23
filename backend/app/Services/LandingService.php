<?php

namespace App\Services;

use App\Repositories\LandingRepository;
use Illuminate\Support\Facades\Log;

class LandingService
{
    protected $landingRepo;

    public function __construct(LandingRepository $landingRepo)
    {
        $this->landingRepo = $landingRepo;
    }

    public function getLandingData()
    {
        Log::info('LandingService@getLandingData called');

        $data = $this->landingRepo->fetchData();

        Log::info('LandingService@getLandingData returning', $data);

        return $data;
    }
}