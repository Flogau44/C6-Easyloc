<?php

namespace App\Repository;

use App\Document\Customer;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Repository CustomerRepository
 * Gère l'accès aux clients.
 */
class CustomerRepository extends DocumentRepository
{
    public function findCustomerByName(string $firstName, string $lastName): ?Customer
    {
        return $this->findOneBy(['firstName' => $firstName, 'lastName' => $lastName]);
    }
}