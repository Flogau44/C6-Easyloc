<?php

namespace App\Tests\Document;

use PHPUnit\Framework\TestCase;
use App\Document\Vehicle;

class VehicleTest extends TestCase
{
    public function testVehicleProperties(): void
    {
        $vehicle = new Vehicle();
        $vehicle->setLicencePlate('AB-123-CD');
        $vehicle->setKm(45000);
        $vehicle->setInformations('Aucune dégradation');

        $this->assertEquals('AB-123-CD', $vehicle->getLicencePlate());
        $this->assertEquals(45000, $vehicle->getKm());
        $this->assertEquals('Aucune dégradation', $vehicle->getInformations());
    }
}