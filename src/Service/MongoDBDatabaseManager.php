<?php

namespace App\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Customer;
use App\Document\Vehicle;

/**
 * Classe MongoDBDatabaseManager
 * Gère l'accès aux données NoSQL (Customer, Vehicle).
 */
class MongoDBDatabaseManager implements NoSQLDatabaseManagerInterface
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getCustomerByName(string $firstName, string $lastName): ?Customer
    {
        return $this->dm->getRepository(Customer::class)->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    public function getVehicleByLicencePlate(string $licencePlate): ?Vehicle
    {
        return $this->dm->getRepository(Vehicle::class)->findOneBy(['licencePlate' => $licencePlate]);
    }

    public function createCustomer(array $data): void
    {
        $customer = new Customer();
        $customer->setFirstName($data['firstName']);
        $customer->setLastName($data['lastName']);
        $customer->setAddress($data['address']);
        $customer->setPermitNumber($data['permitNumber']);

        $this->dm->persist($customer);
        $this->dm->flush();
    }

    public function createVehicle(array $data): void
    {
        $vehicle = new Vehicle();
        $vehicle->setLicencePlate($data['licencePlate']);
        $vehicle->setKm($data['km']);
        $vehicle->setInformations($data['informations']);

        $this->dm->persist($vehicle);
        $this->dm->flush();
    }

    public function deleteCustomer(string $uid): void
    {
        $customer = $this->dm->getRepository(Customer::class)->find($uid);
        if (!$customer) return;

        $this->dm->remove($customer);
        $this->dm->flush();
    }

    public function deleteVehicle(string $uid): void
    {
        $vehicle = $this->dm->getRepository(Vehicle::class)->find($uid);
        if (!$vehicle) return;

        $this->dm->remove($vehicle);
        $this->dm->flush();
    }
}