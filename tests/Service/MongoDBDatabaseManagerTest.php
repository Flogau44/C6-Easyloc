<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\MongoDBDatabaseManager;

class MongoDBDatabaseManagerTest extends KernelTestCase
{
    public function testGetCustomer()
    {
        self::bootKernel();
        $container = static::getContainer();
        $dbManager = $container->get(MongoDBDatabaseManager::class);

        $customer = $dbManager->getCustomerByName("John", "Doe");
        $this->assertEquals("John", $customer['firstName']);
    }
}