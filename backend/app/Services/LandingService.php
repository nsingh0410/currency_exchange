<?php

namespace App\Services;

use App\Repositories\LandingRepository;

class LandingService
{
    protected $landingRepo;

    public function __construct(LandingRepository $landingRepo)
    {
        $this->landingRepo = $landingRepo;
    }

    public function getLandingData()
    {
        return $this->landingRepo->fetchData();
    }
}