<?php

namespace App\Repository;

use App\Document\Customer;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Repository CustomerRepository
 * Gère l'accès aux clients dans la base MongoDB.
 */
class CustomerRepository extends DocumentRepository
{
    /**
     * Recherche un client en fonction de son prénom et de son nom.
     *
     * @param string $firstName Prénom du client.
     * @param string $lastName Nom du client.
     * @return Customer|null Retourne un objet Customer ou null si aucun résultat.
     */
    public function findCustomerByName(string $firstName, string $lastName): ?Customer
    {
        return $this->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }
}