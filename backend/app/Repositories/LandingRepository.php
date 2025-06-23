<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

class LandingRepository
{
    public function fetchData()
    {
        Log::info('LandingRepository@fetchData called');

        $data = [
            "title" => "Scentre Group",
            "subtitle" => "Built with Laravel + React",
            "features" => ["Fast", "Modern", "Secure"]
        ];

        Log::info('LandingRepository@fetchData returning', $data);

        return $data;
    }
}