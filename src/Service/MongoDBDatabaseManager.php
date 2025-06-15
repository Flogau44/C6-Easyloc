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

    /**
     * Constructeur de MongoDBDatabaseManager
     * Injecte DocumentManager pour gérer la connexion et les requêtes MongoDB.
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * Récupère un client en fonction de son prénom et nom.
     *
     * @param string $firstName Prénom du client.
     * @param string $lastName Nom du client.
     * @return Customer|null Retourne l'objet Customer ou null si non trouvé.
     */
    public function getCustomerByName(string $firstName, string $lastName): ?Customer
    {
        return $this->dm->getRepository(Customer::class)->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    /**
     * Récupère un véhicule en fonction de son numéro d'immatriculation.
     *
     * @param string $licencePlate Numéro d'immatriculation du véhicule.
     * @return Vehicle|null Retourne l'objet Vehicle ou null si non trouvé.
     */
    public function getVehicleByLicencePlate(string $licencePlate): ?Vehicle
    {
        return $this->dm->getRepository(Vehicle::class)->findOneBy(['licencePlate' => $licencePlate]);
    }

    /**
     * Crée un nouveau client et l'enregistre dans la base MongoDB.
     *
     * @param array $data Données du client (prénom, nom, adresse, numéro de permis).
     */
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

    /**
     * Crée un nouveau véhicule et l'enregistre dans la base MongoDB.
     *
     * @param array $data Données du véhicule (immatriculation, kilométrage, informations).
     */
    public function createVehicle(array $data): void
    {
        $vehicle = new Vehicle();
        $vehicle->setLicencePlate($data['licencePlate']);
        $vehicle->setKm($data['km']);
        $vehicle->setInformations($data['informations']);

        $this->dm->persist($vehicle);
        $this->dm->flush();
    }

    /**
     * Supprime un client en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du client.
     */
    public function deleteCustomer(string $uid): void
    {
        $customer = $this->dm->getRepository(Customer::class)->find($uid);
        if (!$customer) return;

        $this->dm->remove($customer);
        $this->dm->flush();
    }

    /**
     * Supprime un véhicule en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du véhicule.
     */
    public function deleteVehicle(string $uid): void
    {
        $vehicle = $this->dm->getRepository(Vehicle::class)->find($uid);
        if (!$vehicle) return;

        $this->dm->remove($vehicle);
        $this->dm->flush();
    }
}