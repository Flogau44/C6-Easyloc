<?php

namespace App\Service;

use App\Entity\Contract;
use App\Entity\Billing;

/**
 * Interface SQLDatabaseManagerInterface
 * Définit les méthodes requises pour interagir avec la base MySQL.
 */
interface SQLDatabaseManagerInterface
{
    public function getContractById(int $id): ?Contract;
    public function createContract(array $data): void;
    public function updateContract(int $id, array $data): void;
    public function deleteContract(int $id): void;

    public function getBillingById(int $id): ?Billing;
    public function createBilling(array $data): void;
    public function updateBilling(int $id, array $data): void;
    public function deleteBilling(int $id): void;
}