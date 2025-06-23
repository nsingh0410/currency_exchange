<?php 

namespace App\Repositories;

class LandingRepository
{
    public function fetchData()
    {
        return [
            "title" => "Scentre Group",
            "subtitle" => "Built with Laravel + React",
            "features" => ["Fast", "Modern", "Secure"]
        ];
    }
}