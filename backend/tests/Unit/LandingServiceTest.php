<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\LandingService;
use App\Repositories\LandingRepository;

class LandingServiceTest extends TestCase
{
    /** @test */
    public function it_returns_data_from_the_repository()
    {
        $mockData = [
            "title" => "Test Title",
            "subtitle" => "Test Subtitle",
            "features" => ["A", "B", "C"]
        ];

        // Create a mock of LandingRepository
        $mockRepo = $this->createMock(LandingRepository::class);

        // Define behavior of fetchData()
        $mockRepo->method('fetchData')->willReturn($mockData);

        // Inject the mock into the service
        $service = new LandingService($mockRepo);

        // Call the method
        $result = $service->getLandingData();

        // Assert it returns the mocked data
        $this->assertEquals($mockData, $result);
    }
}
