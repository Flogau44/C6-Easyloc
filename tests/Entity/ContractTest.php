<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Contract;

class ContractTest extends TestCase
{
    public function testContractProperties(): void
    {
        $contract = new Contract();
        
        $contract->setSignDatetime(new \DateTime('2025-06-15 10:00:00'));
        $contract->setLocBeginDatetime(new \DateTime('2025-06-16 10:00:00'));
        $contract->setLocEndDatetime(new \DateTime('2025-06-20 10:00:00'));
        $contract->setReturningDatetime(new \DateTime('2025-06-22 10:00:00'));
        $contract->setPrice(500.00);
        $contract->setCustomerUid('123-456');
        $contract->setVehicleUid('789-012');

        $this->assertEquals(500.00, $contract->getPrice());
        $this->assertEquals('123-456', $contract->getCustomerUid());
        $this->assertEquals('789-012', $contract->getVehicleUid());
        $this->assertGreaterThan($contract->getLocEndDatetime(), $contract->getReturningDatetime());
    }
}