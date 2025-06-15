<?php

namespace App\Service;

use App\Document\Customer;
use App\Document\Vehicle;

/**
 * Interface NoSQLDatabaseManagerInterface
 * Définit les méthodes requises pour interagir avec MongoDB.
 */
interface NoSQLDatabaseManagerInterface
{
    public function getCustomerByName(string $firstName, string $lastName): ?Customer;
    public function getVehicleByLicencePlate(string $licencePlate): ?Vehicle;
    public function createCustomer(array $data): void;
    public function createVehicle(array $data): void;
    public function deleteCustomer(string $uid): void;
    public function deleteVehicle(string $uid): void;
}