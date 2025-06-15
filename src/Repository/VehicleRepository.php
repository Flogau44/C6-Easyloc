<?php

namespace App\Repository;

use App\Document\Vehicle;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Repository VehicleRepository
 * Gère l'accès aux véhicules dans la base MongoDB.
 */
class VehicleRepository extends DocumentRepository
{
    /**
     * Récupère un véhicule en fonction de son numéro d'immatriculation.
     *
     * @param string $licencePlate Numéro d'immatriculation du véhicule.
     * @return Vehicle|null Retourne un objet Vehicle ou null si non trouvé.
     */
    public function findVehicleByLicencePlate(string $licencePlate): ?Vehicle
    {
        return $this->findOneBy(['licencePlate' => $licencePlate]);
    }

    /**
     * Compte le nombre de véhicules dont le kilométrage est compris entre deux valeurs données.
     *
     * @param int $minKm Kilométrage minimum.
     * @param int $maxKm Kilométrage maximum.
     * @return int Retourne le nombre de véhicules correspondant aux critères.
     */
    public function countVehiclesByMileage(int $minKm, int $maxKm): int
    {
        return $this->createQueryBuilder()
            ->field('km')->gte($minKm)->lte($maxKm) // Filtre les véhicules entre minKm et maxKm
            ->count() // Compte le nombre de résultats
            ->getQuery()
            ->execute(); // Exécute la requête et retourne le résultat
    }
}