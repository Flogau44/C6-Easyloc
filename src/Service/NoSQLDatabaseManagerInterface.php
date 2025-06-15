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
    /**
     * Récupère un client en fonction de son prénom et de son nom.
     *
     * @param string $firstName Prénom du client.
     * @param string $lastName Nom du client.
     * @return Customer|null Retourne un objet Customer ou null si aucun résultat.
     */
    public function getCustomerByName(string $firstName, string $lastName): ?Customer;

    /**
     * Récupère un véhicule en fonction de son numéro d'immatriculation.
     *
     * @param string $licencePlate Numéro d'immatriculation du véhicule.
     * @return Vehicle|null Retourne un objet Vehicle ou null si aucun résultat.
     */
    public function getVehicleByLicencePlate(string $licencePlate): ?Vehicle;

    /**
     * Crée un nouveau client et l'enregistre dans la base MongoDB.
     *
     * @param array $data Données du client (prénom, nom, adresse, numéro de permis).
     */
    public function createCustomer(array $data): void;

    /**
     * Crée un nouveau véhicule et l'enregistre dans la base MongoDB.
     *
     * @param array $data Données du véhicule (immatriculation, kilométrage, informations).
     */
    public function createVehicle(array $data): void;

    /**
     * Supprime un client en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du client.
     */
    public function deleteCustomer(string $uid): void;

    /**
     * Supprime un véhicule en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du véhicule.
     */
    public function deleteVehicle(string $uid): void;
}