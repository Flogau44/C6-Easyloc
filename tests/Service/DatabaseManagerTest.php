<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\MySQLDatabaseManager;
use App\Entity\Contract;

class DatabaseManagerTest extends KernelTestCase
{
    public function testCreateContract()
    {
        self::bootKernel();
        $container = static::getContainer();
        $dbManager = $container->get(MySQLDatabaseManager::class);

        $data = ['price' => 250.50];
        $dbManager->createContract($data);

        $contract = $dbManager->getContractById(1);
        $this->assertEquals(250.50, $contract['price']);
    }

    public function testDeleteContract()
    {
        self::bootKernel();
        $container = static::getContainer();
        $dbManager = $container->get(MySQLDatabaseManager::class);

        $dbManager->deleteContract(1);
        $this->assertNull($dbManager->getContractById(1));
    }
}