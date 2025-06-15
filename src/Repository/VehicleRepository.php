<?php

namespace App\Repository;

use App\Document\Vehicle;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Repository VehicleRepository
 * Gère l'accès aux véhicules.
 */
class VehicleRepository extends DocumentRepository
{
    public function findVehicleByLicencePlate(string $licencePlate): ?Vehicle
    {
        return $this->findOneBy(['licencePlate' => $licencePlate]);
    }

    public function countVehiclesByMileage(int $minKm, int $maxKm): int
    {
        return $this->createQueryBuilder()
            ->field('km')->gte($minKm)->lte($maxKm)
            ->count()
            ->getQuery()
            ->execute();
    }
}