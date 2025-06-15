<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Billing;

class BillingTest extends TestCase
{
    public function testBillingProperties(): void
    {
        $billing = new Billing();
        $billing->setAmount(200.00);

        $this->assertEquals(200.00, $billing->getAmount());
    }
}