<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Document Customer
 * Représente un client dans la base MongoDB.
 */
#[ODM\Document]
class Customer
{
    #[ODM\Id]
    private string $uid;

    #[ODM\Field(type: "string")]
    private string $firstName;

    #[ODM\Field(type: "string")]
    private string $lastName;

    #[ODM\Field(type: "string")]
    private string $address;

    #[ODM\Field(type: "string")]
    private string $permitNumber;

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setPermitNumber(string $permitNumber): void
    {
        $this->permitNumber = $permitNumber;
    }
}