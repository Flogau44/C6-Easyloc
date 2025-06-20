<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\MySQLDatabaseManager;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseManagerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private MySQLDatabaseManager $dbManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        // Vérification que le service est bien récupéré
        $this->em = $container->get('doctrine')->getManager();
        $this->dbManager = $container->get(MySQLDatabaseManager::class);
    }

    /**
     * Teste la création d'un contrat.
     */
    public function testCreateContract(): void
    {
        $data = [
            'locBegin' => '2025-06-15 10:00:00',
            'locEnd' => '2025-06-20 10:00:00',
            'price' => 500.00,
            'customer_uid' => '123-456',
            'vehicle_uid' => '789-012'
        ];

        $this->dbManager->createContract($data);

        $contract = $this->dbManager->getContractById(1);
        $this->assertNotNull($contract);
        $this->assertEquals(500.00, $contract->getPrice());
    }

    /**
     * Teste la suppression d'un contrat.
     */
    public function testDeleteContract(): void
    {
        $this->dbManager->deleteContract(1);
        $contract = $this->dbManager->getContractById(1);
        $this->assertNull($contract);
    }
}