<?php

namespace App\Tests\Service;

use App\Service\VehicleProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VehicleProviderTest extends KernelTestCase
{
    private VehicleProvider $service;

    protected function setUp(): void
    {
        self::bootKernel();

        /** @var VehicleProvider $vehicles */
        $this->service = static::getContainer()->get(VehicleProvider::class);
    }

    public function testGetAll(): void
    {
        $vehicles = $this->service->getVehicles();

        $this->assertIsArray($vehicles);
        $this->assertNotEmpty($vehicles);
    }

    public function testGetByLine(): void
    {
        $vehicles = $this->service->getVehicles(line: '140');
        $vehicle = $vehicles[0];

        $this->assertEquals('140', $vehicle->getLine());
    }
}
