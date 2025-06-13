<?php

namespace App\Repository;

use App\Document\Customer;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class CustomerRepository extends ServiceDocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        parent::__construct($dm, Customer::class);
    }

    public function findByName(string $firstName, string $secondName): ?Customer
    {
        return $this->createQueryBuilder()
            ->field('firstName')->equals($firstName)
            ->field('secondName')->equals($secondName)
            ->getQuery()
            ->getSingleResult();
    }
}