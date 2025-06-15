<?php

namespace App\Tests\Document;

use PHPUnit\Framework\TestCase;
use App\Document\Customer;

class CustomerTest extends TestCase
{
    public function testCustomerProperties(): void
    {
        $customer = new Customer();
        $customer->setFirstName('John');
        $customer->setLastName('Doe');
        $customer->setAddress('10 rue de Paris');
        $customer->setPermitNumber('A12345');

        $this->assertEquals('John', $customer->getFirstName());
        $this->assertEquals('Doe', $customer->getLastName());
        $this->assertEquals('A12345', $customer->getPermitNumber());
    }
}