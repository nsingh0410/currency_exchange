<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Api\LandingController;
use App\Services\LandingService;
use Illuminate\Http\JsonResponse;

class LandingControllerTest extends TestCase
{
    public function testIndexReturnsJsonResponse()
    {
        // Arrange: create fake data and a mock of LandingService
        $expectedData = ['title' => 'Welcome', 'description' => 'Landing page content'];

        $mockService = $this->createMock(LandingService::class);
        $mockService->method('getLandingData')
                    ->willReturn($expectedData);

        $controller = new LandingController($mockService);

        // Act: call the index method
        $response = $controller->index();

        // Assert: check the response is JSON and contains expected data
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedData, $response->getData(true));
    }
}