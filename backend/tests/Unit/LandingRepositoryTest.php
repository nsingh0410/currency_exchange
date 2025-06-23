<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\LandingRepository;

class LandingRepositoryTest extends TestCase
{
    /** @test */
    public function it_returns_expected_landing_data()
    {
        $repository = new LandingRepository();

        $data = $repository->fetchData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals('Scentre Group', $data['title']);

        $this->assertArrayHasKey('subtitle', $data);
        $this->assertEquals('Built with Laravel + React', $data['subtitle']);
    }
}
