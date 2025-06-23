<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\LandingService;
use App\Http\Controllers\Api\LandingController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class LandingControllerTest extends TestCase
{
    public function test_index_returns_json_response_on_success()
    {
        // Arrange
        $mockService = Mockery::mock(LandingService::class);
        $expectedData = [
            "title" => "Scentre Group",
            "subtitle" => "Built with Laravel + React",
            "features" => ["Fast", "Modern", "Secure"]
        ];

        $mockService->shouldReceive('getLandingData')
                    ->once()
                    ->andReturn($expectedData);

        // Act
        $controller = new LandingController($mockService);
        $response = $controller->index();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($expectedData, $response->getData(true));
    }

    public function test_index_returns_error_response_on_exception()
    {
        // Arrange
        $mockService = Mockery::mock(LandingService::class);
        $mockService->shouldReceive('getLandingData')
                    ->once()
                    ->andThrow(new Exception('Something went wrong'));

        // Act
        $controller = new LandingController($mockService);
        $response = $controller->index();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());
        $this->assertEquals(['error' => 'Failed to retrieve landing data'], $response->getData(true));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}